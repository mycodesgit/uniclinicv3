<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MDHU Report for the month of</title>

    <style>
		#medreptable {
		  	font-family: Arial;
		  	border-collapse: collapse;
		  	width: 100%;
		  	font-size: 10pt;
		}

		#medreptable td {
			border: 1px solid #000;
		  	padding: 5px;
            font-family: Sans-serif;
		} 
		#medreptable th {
		  	border: 1px solid #000;
		  	font-weight: normal;
		  	padding: 3px;
            font-family: Sans-serif;
		}
    </style>
</head>
<body>
    <div>
        <table id="medreptable">
            <thead>
                <tr>
                    <th colspan="8" style="background:yellow; font-family: DejaVu Sans, sans-serif; font-weight: bold">MEDICAL DENTAL HEALTH UNIT<br>@if (Auth::guard()->user()->campus == 'MC') CPSU MAIN CAMPUS @endif</th>
                    <th style="width: 40px; font-family: DejaVu Sans, sans-serif; font-weight: bold">Report for this month of:</th>
                    <th colspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: bold">
                        @php
                            $monthNum = request('month');
                            $monthName = $monthNum ? date('F', mktime(0, 0, 0, $monthNum, 1)) : '';
                        @endphp
                        {{ $monthName }}
                    </th>
                </tr>
                <tr>
                    <th rowspan="3" style="background:#babcbe; width: 280px">Name of Commodity</th>
                    <th rowspan="2" style="background:#babcbe; width: 40px">Beginning balance (from the previous  Month)</th>
                    <th colspan="3" style="background: #babcbe">Deliveries</th>
                    <th colspan="3" style="background: #babcbe">Stock Transfers</th>
                    <th rowspan="2" style="background: #babcbe">Monthly Consump-tion</th>
                    <th rowspan="2" style="background: #babcbe">Expired Stocks </th>
                    <th style="background:#babcbe; width: 80px">End of Month Stocks</th>
                </tr>
                <tr>
                    <th colspan="2" style="background: #babcbe">Quantity</th>
                    <th rowspan="2" style="background: #babcbe; width: 100px">Lot/Batch No. & Exp Date (don’t live this blank)</th>
                    <th style="background: #babcbe">Received</th>
                    <th style="background: #babcbe">Transferred</th>
                    <th rowspan="2" style="background: #babcbe width: 30px">Recipient  (Office)</th>
                    <th rowspan="2" style="background: #babcbe">(A+B+C) – (D+E+F)</th>
                </tr>
                <tr>
                    <th style="background: #babcbe">(A)</th>
                    <th style="background: #babcbe">(B)</th>
                    <th style="background: #babcbe">Date</th>
                    <th style="background: #babcbe">(C)</th>
                    <th style="background: #babcbe">(D)</th>
                    <th style="background: #babcbe">(E)</th>
                    <th style="background: #babcbe">(F)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $letters = range('A', 'Z'); // letters A-Z
                @endphp

                @forelse ($monthmed as $category => $medicines)
                    <tr style="background:yellow; font-weight:bold;">
                        <td colspan="11">{{ $letters[$loop->index] ?? '' }}. {{ $category }}</td>
                    </tr>

                    @foreach ($medicines as $med)
                        @php
                            $selectedMonth = request('month', date('m'));
                            $selectedYear = $currentYear ?? date('Y');

                            // Beginning Balance - Batches received BEFORE the selected month
                            $begBal = $med->batches
                                ->filter(function($batch) use ($selectedMonth, $selectedYear) {
                                    if (!$batch->received_date) return false;
                                    $date = \Carbon\Carbon::parse($batch->received_date);
                                    return $date->year < $selectedYear || ($date->year == $selectedYear && $date->month < $selectedMonth);
                                })
                                ->sum('quantity_received');

                            // Deliveries - Batches received DURING the selected month
                            $currentBatches = $med->batches
                                ->filter(function($batch) use ($selectedMonth, $selectedYear) {
                                    if (!$batch->received_date) return false;
                                    $date = \Carbon\Carbon::parse($batch->received_date);
                                    return $date->year == $selectedYear && $date->month == $selectedMonth;
                                });

                            $delivQty = $currentBatches->sum('quantity_received');
                            $stockRec = 0;   // (C)
                            $stockTrans = 0; // (D)

                            // Calculate Monthly Consumption (E) from MedicineTransaction logs
                            $consumption = $med->transactions
                                ->filter(function($transaction) use ($selectedMonth, $selectedYear) {
                                    if (!$transaction->created_at) return false;
                                    $date = \Carbon\Carbon::parse($transaction->created_at);
                                    return $date->year == $selectedYear 
                                        && $date->month == $selectedMonth 
                                        && in_array(strtolower($transaction->transaction_type), ['dispensed', 'issued', 'dispense']);
                                })
                                ->sum('quantity');

                            $expired = 0; // (F)

                            // Lot/Batch details
                            $batchDetails = $currentBatches->map(function($b) {
                                $exp = $b->expiration_date ? \Carbon\Carbon::parse($b->expiration_date)->format('m/d/Y') : 'N/A';
                                return $b->lotbatch_number . ' (' . $exp . ')';
                            })->implode(', ');

                            // Formula Calculation: (A + B + C) - (D + E + F)
                            $endOfMonth = ($begBal + $delivQty + $stockRec) - ($stockTrans + $consumption + $expired);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}. {{ $med->code }} {{ $med->name }}</td>
                            <td>{{ $begBal }}</td>
                            <td>{{ $delivQty }}</td>
                            <td>{{ $batchDetails }}</td>
                            <td></td>
                            <td>{{ $stockRec }}</td>
                            <td>{{ $stockTrans }}</td>
                            <td></td>
                            <td>{{ $consumption }}</td>
                            <td>{{ $expired }}</td>
                            <td>{{ $endOfMonth }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="11" style="text-align: center">No data available for this month</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="11"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="font-style: italic; font-weight: bold">Prepared by:</td>
                    <td colspan="5" style="font-style: italic; font-weight: bold">Noted by:</td>
                </tr>
                <tr>
                    <td colspan="1">Signature over Printed Name</td>
                    <td colspan="5"></td>
                    <td colspan="1">Signature over Printed Name</td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td colspan="1">Designation</td>
                    <td colspan="5"></td>
                    <td colspan="1">Designation</td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td colspan="6">Date:</td>
                    <td colspan="5">Date:</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>