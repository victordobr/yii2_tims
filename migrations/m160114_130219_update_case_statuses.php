<?php

use yii\db\Schema;
use yii\db\Migration;

class m160114_130219_update_case_statuses extends Migration
{
    const TABLE = 'CaseStatus';

    private static $statuses = [
        'new' => [
            // upload evidence
            1010 => ['Incomplete record', ''],
            1020 => ['Complete record', 'deactivation window'],
            1021 => ['Complete record', 'deactivation window'],
            1030 => ['Awaiting deactivation', ''],
            1040 => ['Deactivated record', ''],
            1999 => ['Hold', ''],
            // review evidence
            2010 => ['Viewed record', ''],
            2020 => ['Approved record', 'change window'],
            2021 => ['Approved record', 'change window'],
            2030 => ['Rejected record', 'change window'],
            2031 => ['Rejected record', 'change window'],
            2040 => ['Awaiting change', ''],
            2999 => ['Hold', ''],
            // wait DMV data (NLETS)
            3010 => ['Query submitted', ''],
            3020 => ['DMV data retrieved', 'complete'],
            3021 => ['DMV data retrieved', 'incomplete – non critical'],
            3030 => ['DMV data retrieved', 'incomplete - critical'],
            3031 => ['DMV data corrupt', ''],
            3032 => ['DMV data not available', ''],
            3033 => ['DMV data multiple match', ''],
            3999 => ['Hold', ''],
            // print/QC AND mail citation
            4010 => ['Printed', 'P1'],
            4020 => ['QC confirmed good', 'P1'],
            4030 => ['QC bad', 'reprint P1'],
            4040 => ['Printed', 'P2'],
            4050 => ['QC confirmed good', 'P2'],
            4060 => ['QC bad', 'reprint P2'],
            4070 => ['[RFU]	Mailed', ''],
            4999 => ['Hold', ''],
            // monitor and update status
            5010 => ['[RFU] Received', 'P1'],
            5011 => ['Viewed record', 'P1'],
            5020 => ['[RFU] Received', 'P2'],
            5021 => ['Viewed record', 'P2'],
            5030 => ['Paid', ''],
            5040 => ['Court date requested', ''],
            5041 => ['Court date set', ''],
            5042 => ['Court verdict returned', ''],
            5050 => ['Disputed', 'affidavit'],
            5060 => ['Overdue', 'P1'],
            5061 => ['Overdue', 'P1'],
            5070 => ['Sent to collections', ''],
            5999 => ['Hold', ''],
            6010 => ['Closed', 'paid'],
            6011 => ['Closed', 'unpaid'],
            6020 => ['Archived', ''],
            6021 => ['Record hold', ''],
            6022 => ['Marked for purge', '30d'],
        ],
        'old' => [
            1 => ['Waiting for Evidence Review', 'Waiting for Evidence Review'],
            2 => ['No Sufficient Evidence', 'No Sufficient Evidence'],
            3 => ['Sufficient', 'Sufficient'],
            4 => ['Awaiting Owner Info', 'Awaiting Owner Info'],
            5 => ['To be printed', 'To be printed'],
            6 => ['Ticket Mailed', 'Ticket Mailed'],
            7 => ['Paid', 'Paid'],
            8 => ['Disputed', 'Disputed'],
            9 => ['Payment Date Expired', 'Payment Date Expired'],
            10 => ['Overdue', 'Overdue'],
            11 => ['Overdue-Open', 'Overdue-Open'],
            12 => ['Open', 'Open'],
            13 => ['Payment By Cheque', 'Payment By Cheque'],
            14 => ['Payment By Cash', 'Payment By Cash'],
            15 => ['Ticket Print', 'Ticket Print'],
        ]
    ];

    public function up()
    {
        $this->truncateTable(self::TABLE);
        foreach (self::$statuses['new'] as $id => $attributes) {
            $this->insert(self::TABLE, [
                'id' => $id,
                'name' => $attributes[0],
                'description' => $attributes[1],
            ]);
        }
    }

    public function down()
    {
        $this->truncateTable(self::TABLE);
        foreach (self::$statuses['old'] as $id => $attributes) {
            $this->insert(self::TABLE, [
                'id' => $id,
                'name' => $attributes[0],
                'description' => $attributes[1],
            ]);
        }
    }

}
