<?php

namespace YOOtheme\Source\K2;

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Registry\Registry;
use YOOtheme\Path;

require_once JPATH_SITE.'/administrator/components/com_k2/models/extrafield.php';
require_once JPATH_SITE.'/administrator/components/com_k2/models/extrafields.php';

class K2Helper
{
    public static function getCategory(int $categoryId)
    {
        $user = Factory::getUser();
        $category = Table::getInstance('K2Category', 'Table');

        $category->load($categoryId);

        if (!$category->published || $category->trash) {
            return null;
        }

        if (!in_array($category->access, $user->getAuthorisedViewLevels())) {
            return null;
        }

        return $category;
    }

    public static function getExtraFieldsGroups(): array
    {
        $fieldsModel = new \K2ModelExtraFields();

        return $fieldsModel->getGroups();
    }

    public static function getExtraFieldsByGroup(int $groupId): array
    {
        $fieldModel = new \K2ModelExtraField();

        $fields = $fieldModel->getExtraFieldsByGroup($groupId);

        foreach ($fields as &$field) {
            self::processExtraField($field);
        }

        return $fields;
    }

    public static function countCategoryItems(int $categoryId): int
    {
        $model = new \K2ModelItemlist();

        return $model->countCategoryItems($categoryId);
    }

    public static function getCategoryFirstChildren(int $categoryId): array
    {
        $model = new \K2ModelItemlist();

        return $model->getCategoryFirstChildren($categoryId);
    }

    public static function getCategoryImage($category)
    {
        return \K2HelperUtilities::getCategoryImage(Path::basename($category->image), $category->params);
    }

    public static function getExtraFieldInfo(int $fieldId)
    {
        $model = new \K2ModelExtraField();

        $field = $model->getExtraFieldInfo($fieldId);

        self::processExtraField($field);

        return $field;
    }

    protected static function processExtraField(&$field)
    {
        $field->value = (object) (json_decode($field->value, true)[0] ?? []);
        $field->alias = $field->value->alias ?? '';

        if (empty($field->alias)) {
            $searches = array('??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', 'y', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??');
            $replacements = array('A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'D', 'd', 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'J', 'j', 'K', 'k', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'N', 'n', 'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'y', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 'a', 'b', 'g', 'd', 'e', 'z', 'h', 'th', 'i', 'k', 'l', 'm', 'n', 'x', 'o', 'p', 'r', 's', 't', 'y', 'f', 'ch', 'ps', 'w', 'A', 'B', 'G', 'D', 'E', 'Z', 'H', 'Th', 'I', 'K', 'L', 'M', 'X', 'O', 'P', 'R', 'S', 'T', 'Y', 'F', 'Ch', 'Ps', 'W', 'a', 'e', 'h', 'i', 'o', 'y', 'w', 'A', 'E', 'H', 'I', 'O', 'Y', 'W', 'i', 'i', 'y', 's', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Zero', 'A', 'A', 'A', 'E', 'E', 'E', 'B', 'V', 'G', 'G', 'G', 'G', 'G', 'D', 'E', 'E', 'YO', 'E', 'E', 'E', 'YE', 'ZH', 'DZH', 'ZH', 'DZH', 'Z', 'Z', 'DZ', 'DZ', 'DZ', 'I', 'I', 'I', 'I', 'I', 'JI', 'I', 'Y', 'Y', 'J', 'K', 'Q', 'Q', 'K', 'Q', 'K', 'L', 'L', 'L', 'M', 'M', 'N', 'N', 'N', 'N', 'N', 'N', 'O', 'O', 'O', 'O', 'O', 'P', 'PF', 'P', 'P', 'S', 'S', 'T', 'TH', 'T', 'K', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'F', 'H', 'H', 'H', 'TS', 'TS', 'CH', 'CH', 'CH', 'CH', 'CH', 'DZ', 'SH', 'SHT', 'A', 'Y', 'Y', 'Y', 'Y', 'E', 'E', 'YU', 'YA', 'a', 'a', 'a', 'e', 'e', 'e', 'b', 'v', 'g', 'g', 'g', 'g', 'g', 'y', 'd', 'e', 'e', 'yo', 'e', 'e', 'e', 'ye', 'zh', 'dzh', 'zh', 'dzh', 'z', 'z', 'dz', 'dz', 'dz', 'i', 'i', 'i', 'i', 'i', 'ji', 'i', 'y', 'y', 'j', 'k', 'q', 'q', 'k', 'q', 'k', 'l', 'l', 'l', 'm', 'm', 'n', 'n', 'n', 'n', 'n', 'n', 'o', 'o', 'o', 'o', 'o', 'p', 'pf', 'p', 'p', 's', 's', 't', 'th', 't', 'k', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'f', 'h', 'h', 'h', 'ts', 'ts', 'ch', 'ch', 'ch', 'ch', 'ch', 'dz', 'sh', 'sht', 'a', 'y', 'y', 'y', 'y', 'e', 'e', 'yu', 'ya');
            $field->alias = str_replace($searches, $replacements, $field->name);

            $filter = \JFilterInput::getInstance();
            $field->alias = $filter->clean($field->alias, 'WORD');
        }
    }

    public static function getTags()
    {
        $db = Factory::getDbo();

        $query = "SELECT #__k2_tags.*, (SELECT COUNT(*) FROM #__k2_tags_xref WHERE #__k2_tags_xref.tagID = #__k2_tags.id) AS numOfItems FROM #__k2_tags ORDER BY name";

        $db->setQuery($query);

        return $db->loadObjectList();
    }

    public static function getCategoriesTree()
    {
        require_once JPATH_SITE.'/administrator/components/com_k2/models/categories.php';

        return (new \K2ModelCategories())->categoriesTree();
    }

    public static function parseParams($params): object
    {
        return is_string($params) ? new Registry($params) : $params;
    }
}
