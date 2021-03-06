<?php
namespace Bitrix\Iblock;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class TypeLanguageTable
 *
 * Fields:
 * <ul>
 * <li> IBLOCK_TYPE_ID string(50) mandatory
 * <li> LANGUAGE_ID char(2) mandatory
 * <li> NAME string(100) mandatory
 * <li> SECTIONS_NAME string(100) optional
 * <li> ELEMENTS_NAME string(100) mandatory
 * <li> LANGUAGE reference to {@link \Bitrix\Main\Localization\LanguageTable}
 * </ul>
 *
 * @package Bitrix\Iblock
 */
class TypeLanguageTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_type_lang';
	}

	public static function getMap()
	{
		return array(
			'IBLOCK_TYPE_ID' => array(
				'data_type' => 'string',
				'primary' => true,
				'validation' => array(__CLASS__, 'validateIblockTypeId'),
				'title' => Loc::getMessage('IBLOCK_TYPE_LANG_ENTITY_IBLOCK_TYPE_ID_FIELD'),
			),
			'LANGUAGE_ID' => array(
				'data_type' => 'string',
				'primary' => true,
				'column_name' => 'LID',
				'validation' => array(__CLASS__, 'validateLanguageId'),
				'title' => Loc::getMessage('IBLOCK_TYPE_LANG_ENTITY_LID_FIELD'),
			),
			'NAME' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateName'),
				'title' => Loc::getMessage('IBLOCK_TYPE_LANG_ENTITY_NAME_FIELD'),
			),
			'SECTIONS_NAME' => array(
				'data_type' => 'string',
				'column_name' => 'SECTION_NAME',
				'validation' => array(__CLASS__, 'validateSectionsName'),
				'title' => Loc::getMessage('IBLOCK_TYPE_LANG_ENTITY_SECTION_NAME_FIELD'),
			),
			'ELEMENTS_NAME' => array(
				'data_type' => 'string',
				'required' => true,
				'column_name' => 'ELEMENT_NAME',
				'validation' => array(__CLASS__, 'validateElementsName'),
				'title' => Loc::getMessage('IBLOCK_TYPE_LANG_ENTITY_ELEMENT_NAME_FIELD'),
			),
			'LANGUAGE' => array(
				'data_type' => 'Bitrix\Main\Localization\Language',
				'reference' => array('=this.LID' => 'ref.LID'),
			),
		);
	}
	public static function validateIblockTypeId()
	{
		return array(
			new Entity\Validator\Length(null, 50),
		);
	}
	public static function validateLanguageId()
	{
		return array(
			new Entity\Validator\Length(null, 2),
		);
	}
	public static function validateName()
	{
		return array(
			new Entity\Validator\Length(null, 100),
		);
	}
	public static function validateSectionsName()
	{
		return array(
			new Entity\Validator\Length(null, 100),
		);
	}
	public static function validateElementsName()
	{
		return array(
			new Entity\Validator\Length(null, 100),
		);
	}
}
