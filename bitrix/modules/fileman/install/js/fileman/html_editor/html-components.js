/**
 * Bitrix HTML Editor 3.0
 * Date: 24.04.13
 * Time: 4:23
 *
 * Components class
 */
(function()
{
	function BXEditorComponents(editor)
	{
		this.editor = editor;
		this.phpParser = this.editor.phpParser;
		this.listLoaded = false;
		this.components = this.editor.config.components;
		this.compNameIndex = {};

		this.requestUrl = '/bitrix/admin/fileman_component_params.php';
		this.HandleList();

		this.Init();
	}

	BXEditorComponents.prototype = {
		Init: function()
		{
			BX.addCustomEvent(this.editor, "OnSurrogateDblClick", BX.proxy(this.OnComponentDoubleClick, this));
		},

		GetList: function()
		{
			return this.components;
		},

		HandleList: function()
		{
			if (this.components && this.components.items)
			{
				for(var i = 0; i < this.components.items.length; i++)
					this.compNameIndex[this.components.items[i].name] = i;
			}
		},

		IsComponent: function(code)
		{
			code = this.phpParser.TrimPhpBrackets(code);
			code = this.phpParser.CleanCode(code);

			var oFunction = this.phpParser.ParseFunction(code);
			if (oFunction && oFunction.name.toUpperCase() == '$APPLICATION->INCLUDECOMPONENT')
			{
				var arParams = this.phpParser.ParseParameters(oFunction.params);
				return {
					name: arParams[0],
					template: arParams[1] || "",
					params: arParams[2] || {},
					parentComponent: (arParams[3] && arParams[3] != '={false}') ? arParams[3] : false,
					exParams: arParams[4] || false
				};
			}
			return false;
		},

		IsReady: function()
		{
			return this.listLoaded;
		},

		GetSource: function(params)
		{
			if (!this.arVA)
			{
				this.arVA = {};
			}

			var
				res = "<?$APPLICATION->IncludeComponent(\n" +
					"\t\"" + params.name+"\",\n" +
					"\t\"" + (params.template || "") + "\",\n";

			if (params.params)
			{
				res += "\tArray(\n";

				var
					propValues = params.params,
					i, k, cnt,
					_len1 = "SEF_URL_TEMPLATES_".length,
					_len2 = "VARIABLE_ALIASES_".length,
					SUT, VA, lio, templ_key,
					params_exist = false,
					arVal, arLen, j;

				for (i in propValues)
				{
					//try{
						if (!params_exist)
							params_exist = true;

						if (typeof(propValues[i]) == 'string')
						{
							propValues[i] = this.editor.util.stripslashes(propValues[i]);
						}
						else if (typeof(propValues[i]) == 'object')
						{
							arVal = 'array(';
							arLen = 0;
							for (j in propValues[i])
							{
								if (typeof(propValues[i][j]) == 'string')
								{
									arLen++;
									arVal += '"' + this.editor.util.stripslashes(propValues[i][j]) + '",';
								}
							}
							if (arLen > 0)
								arVal = arVal.substr(0, arVal.length - 1) + ')';
							else
								arVal += ')';

							propValues[i] = arVal;
						}
						else
						{
							continue;
						}

						if (propValues["SEF_MODE"] && propValues["SEF_MODE"].toUpperCase() == "Y")
						{
							//*** Handling SEF_URL_TEMPLATES in SEF = ON***
							if(i.substr(0, _len1) == "SEF_URL_TEMPLATES_")
							{
								templ_key = i.substr(_len1);
								this.arVA[templ_key] = this.CatchVariableAliases(propValues[i]);

								if (!SUT)
								{
									res += "\t\t\"" + i.substr(0, _len1 - 1) + "\" => Array(\n"
									SUT = true;
								}
								res += "\t\t\t\"" + i.substr(_len1) + "\" => ";
								if (this.IsPHPBracket(propValues[i]))
									res += this.TrimPHPBracket(propValues[i]);
								else
									res += "\"" + this.editor.util.addslashes(propValues[i])+"\"";

								res += ",\n";
								continue;
							}
							else if (SUT)
							{
								lio = res.lastIndexOf(",");
								res = res.substr(0,lio)+res.substr(lio+1);
								SUT = false;
								res += "\t\t),\n";
							}

							//*** Handling  VARIABLE_ALIASES  in SEF = ON***
							if(i.substr(0, _len2) == "VARIABLE_ALIASES_")
								continue;
						}
						else if(propValues["SEF_MODE"] == "N")
						{
							//*** Handling SEF_URL_TEMPLATES in SEF = OFF ***
							if (i.substr(0, _len1)=="SEF_URL_TEMPLATES_" || i == "SEF_FOLDER")
								continue;

							//*** Handling VARIABLE_ALIASES  in SEF = OFF ***
							if(i.substr(0, _len2) == "VARIABLE_ALIASES_")
							{
								if (!VA)
								{
									res += "\t\t\"" + i.substr(0, _len2 - 1) + "\" => Array(\n";
									VA = true;
								}
								res += "\t\t\t\"" + i.substr(_len2) + "\" => \"" + this.editor.util.addslashes(propValues[i]) + "\",\n";
								continue;
							}
							else if (VA)
							{
								lio = res.lastIndexOf(",");
								res = res.substr(0, lio) + res.substr(lio + 1);
								VA = false;
								res += "\t\t),\n";
							}
						}

						res += "\t\t\"" + i + "\" => ";
						if (this.IsPHPBracket(propValues[i]))
							res += this.TrimPHPBracket(propValues[i]);
						else if (propValues[i].substr(0, 6).toLowerCase() == 'array(')
							res += propValues[i];
						else
							res += '"' + this.editor.util.addslashes(propValues[i]) + '"';
						res += ",\n";

					//}catch(e){continue;}
				}

				if (VA || SUT)
				{
					lio = res.lastIndexOf(",");
					res = res.substr(0, lio) + res.substr(lio+1);
					VA = false;
					SUT = false;
					res += "\t\t),\n";
				}

				if (propValues["SEF_MODE"] && propValues["SEF_MODE"].toUpperCase() == "Y")
				{
					res += "\t\t\"VARIABLE_ALIASES\" => Array(\n";

					if (this.arVA)
					{
						for (templ_key in this.arVA)
						{
							if (typeof(this.arVA[templ_key]) != 'object')
								continue;
							res += "\t\t\t\""+templ_key+"\" => Array(";

							cnt = 0;
							for (k in this.arVA[templ_key])
							{
								if (typeof(this.arVA[templ_key][k]) != 'string')
									continue;
								cnt++;
								res += "\n\t\t\t\t\""+var_key+"\" => \"" + this.arVA[templ_key][var_key]+"\",";
							}

							if (cnt > 0)
							{
								lio = res.lastIndexOf(",");
								res = res.substr(0, lio) + res.substr(lio + 1);
								res += "\n\t\t\t),\n";
							}
							else
							{
								res += "),\n";
							}
						}
					}

					res += "\t\t),\n";
				}

				if (params_exist)
				{
					lio = res.lastIndexOf(",");
					res = res.substr(0, lio) + res.substr(lio + 1);
				}
				res += "\t)";
			}
			else
			{
				res += "Array()"
			}

			if (params.parentComponent !== false || params.exParams !== false)
			{
				var pc = params.parentComponent;
				if (!pc || pc.toLowerCase() == '={false}')
				{
					res += ",\nfalse";
				}
				else
				{
					if (isPHPBracket(pc))
						res += ",\n" + trimPHPBracket(pc);
					else
						res += ",\n'" + pc + "'";
				}

				if (params.exParams !== false && typeof params.exParams == 'object')
				{
					res += ",\nArray(";
					for (i in params.exParams)
					{
						if (typeof(params.exParams[i]) == 'string')
							res += "\n\t'" + i + "' => '" + this.editor.util.stripslashes(params.exParams[i]) + "',";
					}
					if (res.substr(res.length - 1) == ',')
						res = res.substr(0, res.length - 1) + "\n";
					res += ")";
				}
			}
			res += "\n);?>";

//			if (window.lca)
//			{
//				var key = str_pad_left(++_$compLength, 4, '0');
//				_$arComponents[key] = res;
//				return '#COMPONENT'+String(key)+'#';
//			}
//			else

			return res;
		},

		GetOnDropHtml: function(params)
		{
			var _params = {
				name: params.name
			};
			return this.GetSource(_params);
		},

		CatchVariableAliases: function(str)
		{
			var
				arRes = [], i, matchRes,
				res = str.match(/(\?|&)(.+?)=#([^#]+?)#/ig);

			if (!res)
				return arRes;

			for (i = 0; i < res.length; i++)
			{
				matchRes = res[i].match(/(\?|&)(.+?)=#([^#]+?)#/i);
				arRes[matchRes[3]] = matchRes[2];
			}
			return arRes;
		},

		LoadParamsList: function(params)
		{
			oBXComponentParamsManager.LoadComponentParams(
				{
					name: params.name,
					parent: false,
					template: '',
					exParams: false,
					currentValues: {}
				}
			);
		},

		GetComponentData: function(name)
		{
			var item = this.components.items[this.compNameIndex[name]];
			return item || {};
		},

		IsPHPBracket: function(str)
		{
			return str.substr(0, 2) =='={';
		},

		TrimPHPBracket: function(str)
		{
			return str.substr(2, str.length - 3);
		},

		OnComponentDoubleClick: function(bxTag, origTag, target, e)
		{
			if (origTag && origTag.tag == 'component')
			{
				// Show dialog
				this.ShowPropertiesDialog(origTag.params, bxTag);
			}
		},

		ShowPropertiesDialog: function(component, bxTag)
		{
			// Used to prevent influence of oBXComponentParamsManager to this array...
			var comp = BX.clone(component, 1);
			if (!this.oPropertiesDialog)
			{
				//PropertiesDialog
				this.oPropertiesDialog = this.editor.GetDialog('componentProperties', {oBXComponentParamsManager: oBXComponentParamsManager});

				BX.addCustomEvent(this.oPropertiesDialog, "OnDialogSave", BX.proxy(this.SavePropertiesDialog, this));
			}

			this.currentViewedComponentTag = bxTag;
			this.oPropertiesDialog.SetTitle(BX.message('ComponentPropsTitle').replace('#COMPONENT_NAME#', comp.name));

			this.oPropertiesDialog.SetContent('<span class="bxcompprop-wait-notice">' + BX.message('ComponentPropsWait') + '</span>');
			this.oPropertiesDialog.Show();
			if (this.oPropertiesDialog.oDialog.PARTS.CONTENT_DATA)
			{
				BX.addClass(this.oPropertiesDialog.oDialog.PARTS.CONTENT_DATA, 'bxcompprop-outer-wrap');
			}

			var _this = this;
			var pParamsContainer = BX.create("DIV");

			BX.onCustomEvent(oBXComponentParamsManager, 'OnComponentParamsDisplay',
			[{
				name: comp.name,
				parent: !!comp.parentComponent,
				template: comp.template,
				exParams: comp.exParams,
				currentValues: comp.params,
				container: pParamsContainer,

				callback: function(params, container){
					_this.PropertiesDialogCallback(params, container);
				}
			}]);
		},

		PropertiesDialogCallback: function(params, container)
		{
			if (this.oPropertiesDialog.oDialog.PARTS.CONTENT_DATA)
				BX.addClass(this.oPropertiesDialog.oDialog.PARTS.CONTENT_DATA, 'bxcompprop-outer-wrap');
			this.oPropertiesDialog.SetContent(container);

			var size = this.oPropertiesDialog.GetContentSize();
			BX.onCustomEvent(oBXComponentParamsManager, 'OnComponentParamsResize', [
				size.width,
				size.height
			]);
		},

		SavePropertiesDialog: function()
		{
			var
				ddBxTag = this.currentViewedComponentTag,
				compBxTag = this.editor.GetBxTag(ddBxTag.params.origId),
				currentValues = oBXComponentParamsManager.GetParamsValues();

			ddBxTag.params.origParams.params = currentValues;
			compBxTag.params.params = currentValues;

			this.editor.synchro.FullSyncFromIframe();
		},

		ReloadList: function()
		{
			var _this = this;
			this.editor.Request({
				getData: this.editor.GetReqData('load_components_list',
					{
						site_template: this.editor.GetTemplateId()
					}
				),
				handler: function(res)
				{
					_this.components = _this.editor.config.components = res;
					_this.HandleList();
					_this.editor.componentsTaskbar.BuildTree(_this.components.groups, _this.components.items);
				}
			});
		}
	};

	function __runcomp()
	{
		window.BXHtmlEditor.BXEditorComponents = BXEditorComponents;

		function PropertiesDialog(editor, params)
		{
			params = params || {};
			params.id = 'bx_component_properties';
			params.height = 600;
			params.width =  800;
			params.resizable = true;
			this.oBXComponentParamsManager = params.oBXComponentParamsManager;

			this.id = 'components_properties';

			// Call parrent constructor
			PropertiesDialog.superclass.constructor.apply(this, [editor, params]);

			BX.addClass(this.oDialog.DIV, "bxcompprop-dialog");
			BX.addCustomEvent(this, "OnDialogSave", BX.proxy(this.Save, this));
		}
		BX.extend(PropertiesDialog, window.BXHtmlEditor.Dialog);


		PropertiesDialog.prototype.OnResize = function()
		{
			var
				w = this.oDialog.PARTS.CONTENT_DATA.offsetWidth,
				h = this.oDialog.PARTS.CONTENT_DATA.offsetHeight;

			BX.onCustomEvent(this.oBXComponentParamsManager, 'OnComponentParamsResize', [w, h]);
		};

		PropertiesDialog.prototype.OnResizeFinished = function()
		{
		};

		window.BXHtmlEditor.dialogs.componentProperties = PropertiesDialog;
	}

	if (window.BXHtmlEditor)
		__runcomp();
	else
		BX.addCustomEvent(window, "OnBXHtmlEditorInit", __runcomp);

})();