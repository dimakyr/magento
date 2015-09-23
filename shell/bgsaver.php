<?php

require_once 'abstract.php';

class Smile_Shell_BgSaver extends Mage_Shell_Abstract
{
    public function run()
    {
        if (!$this->getArg('category_id')
            || !$this->getArg('admin_user_id')
            || !$this->getArg('store_id')) {
            $this->usageHelp();
        }
        Mage::setIsDeveloperMode(true);
        $categoryId = $this->getArg('category_id');
        $adminUserId = $this->getArg('admin_user_id');
        $storeId = $this->getArg('store_id');
        //$data = unserialize(base64_decode($this->getArg('data')));
        $data = array(
        'data' => unserialize(base64_decode('YTozOTp7czo4OiJzdG9yZV9pZCI7aTowO3M6OToiZW50aXR5X2lkIjtzOjI6IjE1IjtzOjE0OiJlbnRpdHlfdHlwZV9pZCI7czoxOiI5IjtzOjE2OiJhdHRyaWJ1dGVfc2V0X2lkIjtzOjI6IjEyIjtzOjk6InBhcmVudF9pZCI7aToxMztzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDA3LTA4LTI0IDEzOjMzOjE3IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDEzLTA0LTI4IDA3OjQ2OjU0IjtzOjQ6InBhdGgiO3M6OToiMS8zLzEzLzE1IjtzOjg6InBvc2l0aW9uIjtzOjI6IjE1IjtzOjU6ImxldmVsIjtzOjE6IjMiO3M6MTQ6ImNoaWxkcmVuX2NvdW50IjtzOjE6IjgiO3M6NDoibmFtZSI7czo5OiJDb21wdXRlcnMiO3M6MTI6ImRpc3BsYXlfbW9kZSI7czo4OiJQUk9EVUNUUyI7czo3OiJ1cmxfa2V5IjtzOjEwOiJjb21wdXRlcnMyIjtzOjg6InVybF9wYXRoIjtzOjI3OiJlbGVjdHJvbmljcy9jb21wdXRlcnMyLmh0bWwiO3M6MTA6Im1ldGFfdGl0bGUiO3M6MDoiIjtzOjEzOiJjdXN0b21fZGVzaWduIjtzOjA6IiI7czoxMToicGFnZV9sYXlvdXQiO3M6MDoiIjtzOjEyOiJhbGxfY2hpbGRyZW4iO3M6MjoiMTUiO3M6MTM6InBhdGhfaW5fc3RvcmUiO3M6NToiMTUsMTMiO3M6ODoiY2hpbGRyZW4iO3M6MDoiIjtzOjExOiJkZXNjcmlwdGlvbiI7czowOiIiO3M6MTM6Im1ldGFfa2V5d29yZHMiO3M6MDoiIjtzOjE2OiJtZXRhX2Rlc2NyaXB0aW9uIjtzOjA6IiI7czoyMDoiY3VzdG9tX2xheW91dF91cGRhdGUiO3M6MDoiIjtzOjE3OiJhdmFpbGFibGVfc29ydF9ieSI7czowOiIiO3M6OToiaXNfYW5jaG9yIjtzOjE6IjEiO3M6OToiaXNfYWN0aXZlIjtzOjE6IjEiO3M6MTU6ImluY2x1ZGVfaW5fbWVudSI7czoxOiIxIjtzOjI2OiJjdXN0b21fdXNlX3BhcmVudF9zZXR0aW5ncyI7czoxOiIxIjtzOjI0OiJjdXN0b21fYXBwbHlfdG9fcHJvZHVjdHMiO3M6MToiMSI7czoxMjoibGFuZGluZ19wYWdlIjtzOjA6IiI7czoxODoiZmlsdGVyX3ByaWNlX3JhbmdlIjtOO3M6MjoiaWQiO3M6MjoiMTUiO3M6MTU6ImRlZmF1bHRfc29ydF9ieSI7YjowO3M6MTU6InBvc3RlZF9wcm9kdWN0cyI7YTo3OntpOjI1O3M6MToiMCI7aToyNjtzOjE6IjAiO2k6Mjg7czoxOiIzIjtpOjE0MDtzOjE6IjAiO2k6MTQxO3M6MToiMCI7aToxNDM7czoxOiIwIjtpOjE2MztzOjE6IjAiO31zOjg6InBhdGhfaWRzIjthOjQ6e2k6MDtzOjE6IjEiO2k6MTtzOjE6IjMiO2k6MjtzOjI6IjEzIjtpOjM7czoyOiIxNSI7fXM6MjM6ImlzX2NoYW5nZWRfcHJvZHVjdF9saXN0IjtiOjA7czoxNzoicHJvZHVjdHNfcG9zaXRpb24iO2E6Nzp7aToyNTtzOjE6IjAiO2k6MjY7czoxOiIwIjtpOjI4O3M6MToiMyI7aToxNDA7czoxOiIwIjtpOjE0MTtzOjE6IjAiO2k6MTQzO3M6MToiMCI7aToxNjM7czoxOiIwIjt9fQ==')),
        'orig_data' => unserialize(base64_decode('YTozMzp7czo4OiJzdG9yZV9pZCI7aTowO3M6OToiZW50aXR5X2lkIjtzOjI6IjE1IjtzOjE0OiJlbnRpdHlfdHlwZV9pZCI7czoxOiI5IjtzOjE2OiJhdHRyaWJ1dGVfc2V0X2lkIjtzOjI6IjEyIjtzOjk6InBhcmVudF9pZCI7czoyOiIxMyI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAwNy0wOC0yNCAxMzozMzoxNyI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAxMy0wNC0yOCAwNzo0NjozMCI7czo0OiJwYXRoIjtzOjk6IjEvMy8xMy8xNSI7czo4OiJwb3NpdGlvbiI7czoyOiIxNSI7czo1OiJsZXZlbCI7czoxOiIzIjtzOjE0OiJjaGlsZHJlbl9jb3VudCI7czoxOiI4IjtzOjQ6Im5hbWUiO3M6OToiQ29tcHV0ZXJzIjtzOjEyOiJkaXNwbGF5X21vZGUiO3M6ODoiUFJPRFVDVFMiO3M6NzoidXJsX2tleSI7czoxMDoiY29tcHV0ZXJzMiI7czo4OiJ1cmxfcGF0aCI7czoyNzoiZWxlY3Ryb25pY3MvY29tcHV0ZXJzMi5odG1sIjtzOjEwOiJtZXRhX3RpdGxlIjtzOjA6IiI7czoxMzoiY3VzdG9tX2Rlc2lnbiI7czowOiIiO3M6MTE6InBhZ2VfbGF5b3V0IjtzOjA6IiI7czoxMjoiYWxsX2NoaWxkcmVuIjtzOjI6IjE1IjtzOjEzOiJwYXRoX2luX3N0b3JlIjtzOjU6IjE1LDEzIjtzOjg6ImNoaWxkcmVuIjtzOjA6IiI7czoxMToiZGVzY3JpcHRpb24iO3M6MDoiIjtzOjEzOiJtZXRhX2tleXdvcmRzIjtzOjA6IiI7czoxNjoibWV0YV9kZXNjcmlwdGlvbiI7czowOiIiO3M6MjA6ImN1c3RvbV9sYXlvdXRfdXBkYXRlIjtzOjA6IiI7czoxNzoiYXZhaWxhYmxlX3NvcnRfYnkiO047czo5OiJpc19hbmNob3IiO3M6MToiMSI7czo5OiJpc19hY3RpdmUiO3M6MToiMSI7czoxNToiaW5jbHVkZV9pbl9tZW51IjtzOjE6IjEiO3M6MjY6ImN1c3RvbV91c2VfcGFyZW50X3NldHRpbmdzIjtzOjE6IjEiO3M6MjQ6ImN1c3RvbV9hcHBseV90b19wcm9kdWN0cyI7czoxOiIxIjtzOjEyOiJsYW5kaW5nX3BhZ2UiO047czoxODoiZmlsdGVyX3ByaWNlX3JhbmdlIjtOO30=')),
    );
        $user = Mage::getModel('admin/user')
            ->load($adminUserId);
        Mage::getSingleton('admin/session')
            ->setUser($user)
            ->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());
        $categoryData = $data['data'];
        $categoryOrigData = $data['orig_data'];
        $category = Mage::getModel('catalog/category')
            ->setStoreId($storeId)
            ->load($categoryId);
        foreach ($categoryData as $key => $value) {
            $category->setData($key, $value);
        }
        foreach ($categoryOrigData as $key => $value) {
            $category->setOrigData($key, $value);
        }
        Mage::getSingleton('index/indexer')->processEntityAction(
            $category, Mage_Catalog_Model_Category::ENTITY, Mage_Index_Model_Event::TYPE_SAVE
        );
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f log.php -- [options]
        php -f log.php -- clean --days 1

  clean             Clean Logs
  --days <days>     Save log, days. (Minimum 1 day, if defined - ignoring system value)
  status            Display statistics per log tables
  help              This help

USAGE;
    }
}

$shell = new Smile_Shell_BgSaver();
$shell->run();
