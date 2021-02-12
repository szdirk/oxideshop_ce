<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProvider;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactory;

/**
 * Admin article main newsletter manager.
 * Performs collection and updatind (on user submit) main item information.
 * Admin Menu: Customer Info -> Newsletter -> Main.
 */
class NewsletterMain extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * Executes parent method parent::render(), creates oxnewsletter object
     * and passes it's data to Smarty engine. Returns name of template file
     * "newsletter_main.tpl".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $soxId = $this->_aViewData["oxid"] = $this->getEditObjectId();
        $oNewsletter = oxNew(\OxidEsales\Eshop\Application\Model\Newsletter::class);

        if (isset($soxId) && $soxId != "-1") {
            $oNewsletter->load($soxId);
            $this->_aViewData["edit"] = $oNewsletter;
        }

        // generate editor
        $this->_aViewData["editor"] = $this->_generateTextEditor(
            "100%",
            255,
            $oNewsletter,
            "oxnewsletter__oxtemplate"
        );

        return "newsletter_main.tpl";
    }

    /**
     * Export recipients to CSV
     */
    public function save(): void
    {
        $connectionProvider = new ConnectionProvider();
        $queryBuilderFactory = new QueryBuilderFactory($connectionProvider);
        $queryBuilder = $queryBuilderFactory->create();

        $queryBuilder
            ->select('*')
            ->from('oxuser')
            ->orderBy('oxuser.oxcreate', 'DESC');

        $users = $queryBuilder->execute()->fetchAllAssociative();
        $this->downloadCSV("data_export_" . date("Y-m-d") . ".csv");
        echo $this->array2CSV($users);
        die();
    }

    public function downloadCSV($filename): void
    {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    /**
     * @param array $array
     *
     * @return string|false
     */
    public function array2CSV(array &$array)
    {
        if (count($array) === 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            fputcsv($df, $row);
        }
        fclose($df);

        return ob_get_clean();
    }
}
