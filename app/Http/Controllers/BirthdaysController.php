<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Akaunting\Apexcharts\Chart;
use App\Models\Account;

class BirthdaysController extends Controller
{

    public function shows(Request $request)
    {
        $current_birthdays_page = $request->query('current_birthdays_page', 1);
        $current_birthdays_per_page = $request->query('current_birthdays_per_page', 30);

        // Get all accounts with birth_date and calculate the difference between the birth_date and now. Filter the accounts with a difference between -7 and 0. Order the accounts by the difference. 
        $current_birthdays = Account::select(
            'id',
            'mail',
            'birth_date',
            DB::raw("DATE_ADD(birth_date, INTERVAL 7 DAY) as ending_date")
        )
            ->whereNotNull('birth_date')
            ->whereBetween(DB::raw("DATEDIFF(STR_TO_DATE(CONCAT(DATE_FORMAT(birth_date, '%d-%m'), '-', YEAR(NOW())), '%d-%m-%Y'), NOW())"), [-7, 0])
            ->where(function ($query) {
                // Get the latest use for the account and check if the birth_date is after the latest use. If it is, the account is not expired.
                $query->whereRaw("STR_TO_DATE(CONCAT(DATE_FORMAT(birth_date, '%d-%m'), '-', YEAR(NOW())), '%d-%m-%Y') > IFNULL((SELECT MAX(used_at) FROM account_uses WHERE account_uses.account_id = accounts.id), birth_date)");
            })
            ->orderBy(DB::raw("DATEDIFF(STR_TO_DATE(CONCAT(DATE_FORMAT(birth_date, '%d-%m'), '-', YEAR(NOW())), '%d-%m-%Y'), NOW())"));

        $total_current_birthdays = $current_birthdays->get()->count();
        $rows_current_birthdays = $current_birthdays->skip(($current_birthdays_page - 1) * $current_birthdays_per_page)->take($current_birthdays_per_page)->get()->toArray();

        foreach ($rows_current_birthdays as $key => $row) {
            $rows_current_birthdays[$key]['mail'] = '<a href="' . route('accounts.show', ['account' => $row['id'], 'tab' => 'Informations']) . '">' . $row['mail'] . '</a>';

            unset($rows_current_birthdays[$key]['id']);
        }

        return view('birthdays.shows', [
            'currentBirthdays' => [
                'total' => $total_current_birthdays,
                'columns' => [
                    'Compte',
                    'Date d\'anniversaire',
                    'Date d\'expiration'
                ],
                'rows' => $rows_current_birthdays,
                'pagination' => [
                    'current' => $current_birthdays_page,
                    'total' => ceil($total_current_birthdays / $current_birthdays_per_page),
                    'next' => [
                        'name' => 'Suivant',
                        'url' => route('birthdays.shows', ['current_birthdays_page' => min($current_birthdays_page + 1, ceil($total_current_birthdays / $current_birthdays_per_page))])
                    ],
                    'previous' => [
                        'name' => 'Précédent',
                        'url' => route('birthdays.shows', ['snapshots_request_page' => max($current_birthdays_page - 1, 1)])
                    ]
                ]
            ],
            'chart' => $this->chart()
        ]);
    }

    public function chart(): Chart
    {
        $accountsPerDay = DB::select("SELECT
            date, COUNT(*)-1 as value
        FROM (
            SELECT date
            FROM all_dates
            GROUP BY date
            UNION ALL (
                SELECT CONCAT(YEAR(NOW()), DATE_FORMAT(birth_date, '-%m-%d')) as date
                FROM accounts
                WHERE birth_date is not null
            )
        ) accounts
        GROUP BY date");

        $labels = [];
        $dataSet1 = [];
        $dataSet2 = [];
        $dataSet3 = [];
        foreach ($accountsPerDay as $accountPerDay) {
            $labels[] = $accountPerDay->date;
            $dataSet1[] = $accountPerDay->value;
            $dataSet2[] = max(10 - $accountPerDay->value, 0);

            $dataSet3[count($dataSet1) - 1] = 1;
            for ($i = max(count($dataSet1) - 8, 0); $i < count($dataSet1); $i++) {
                if ($dataSet1[$i] > 0) {
                    $dataSet3[count($dataSet1) - 1] = 0;
                }
            }
        }

        for ($i = 0; $i < count($dataSet3); $i++) {
            if ($dataSet3[$i] == 1) {
                $dataSet3[$i] = max($dataSet1) / 2;
            }
        }

        $chart = (new Chart)->setType('line')
            ->setWidth('100%')
            ->setHeight(450)
            ->setToolbar(['autoSelected' => 'zoom', 'show' => true])
            ->setMarkersSize(0)
            ->setTitle('Anniversaires des comptes sur l\'année')
            ->setSubtitle('')
            ->setXaxisType('datetime')
            ->setXaxisCategories($labels)
            ->setDataset('Comptes', 'line', $dataSet1)
            ->setDataset('Comptes manquants', 'line', $dataSet2)
            ->setDataset('Aucun compte', 'column', $dataSet3);

        return $chart;
    }
}
