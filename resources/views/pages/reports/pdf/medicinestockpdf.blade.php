<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STOCK CARD</title>

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
        <div style="text-align: right; font-style: italic; font-weight: normal">
            <p>Appendix 58</p>
        </div>
        <div style="text-align: center">
            <h3>STOCK CARD</h3>
        </div>

        <br>
        <div class="details" style="margin-top: 20px; margin-left: 0px;">
            <span style="display: inline-block; width: 100px; vertical-align: top; font-weight: bold">Entity Name:</span>
            <div style="display: inline-block; margin-left: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 250px;">
                <span style="font-weight: bold; text-transform: uppercase;">{{ $medicine->code }}</span>
            </div>
        </div>

        <div class="details" style="float: right; margin-top: -15px; margin-right: 10px;">
            <span style="display: inline-block; width: 100px; vertical-align: top; font-weight: bold">Fund Cluster:</span>
            <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 100px;">
                <span style="font-weight: bold">&nbsp;</span>
            </div>
        </div>
        
        <br>

        <table id="medreptable">
            <thead>
                <tr>
                    <th colspan="5" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: left;">Item : {{ $medicine->name }}</th>
                    <th colspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: left; width: 120px; white-space: nowrap;">Stock No. : {{ $medicine->code }}</th>
                </tr>
                <tr>
                    <th colspan="5" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: left">Description : {{ $medicine->description }}</th>
                    <th colspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: left; width: 120px; white-space: nowrap;">Re-order Point. : {{ $medicine->reorder_level }}</th>
                </tr>
                <tr>
                    <th colspan="5" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: left">Unit of Measurement : {{ $medicine->unit }}</th>
                    <th colspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: left; width: 120px;"></th>
                </tr>
                <tr>
                    <th rowspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: center">Date</th>
                    <th rowspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: center">Reference</th>
                    <th style="font-family: DejaVu Sans, sans-serif; font-weight: normal; font-style:italic; text-align: center">Receipt</th>
                    <th colspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; font-style:italic; text-align: center">Issue</th>
                    <th style="font-family: DejaVu Sans, sans-serif; font-weight: normal; font-style:italic; text-align: center">Balance</th>
                    <th rowspan="2" style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: center">No. of Days to Consume</th>
                </tr>
                <tr>
                    <th style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: center">Qty.</th>
                    <th style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: center">Qty.</th>
                    <th style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: center">Office</th>
                    <th style="font-family: DejaVu Sans, sans-serif; font-weight: normal; text-align: center">Qty.</th>
                </tr>
            </thead>
            <tbody>
                @php $runningBalance = 0; @endphp
                @forelse ($stockCardEntries as $entry)
                    @php
                        if (!empty($entry['receipt'])) {
                            $runningBalance += $entry['receipt'];
                        } elseif (!empty($entry['issue'])) {
                            $runningBalance -= $entry['issue'];
                        }
                    @endphp
                    <tr>
                        <td style="font-family: DejaVu Sans, sans-serif; text-align: center;">
                            {{ $entry['date'] ? \Carbon\Carbon::parse($entry['date'])->format('m/d/Y') : '' }}
                        </td>
                        <td style="font-family: DejaVu Sans, sans-serif; text-align: center;">
                            {{ $entry['reference'] }}
                        </td>
                        <td style="font-family: DejaVu Sans, sans-serif; text-align: center;">
                            {{ $entry['receipt'] ?? '' }}
                        </td>
                        <td style="font-family: DejaVu Sans, sans-serif; text-align: center;">
                            {{ $entry['issue'] ?? '' }}
                        </td>
                        <td style="font-family: DejaVu Sans, sans-serif; text-align: center;">
                            {{ $entry['office'] ?? '' }}
                        </td>
                        <td style="font-family: DejaVu Sans, sans-serif; text-align: center;">
                            {{ $runningBalance }}
                        </td>
                        <td style="font-family: DejaVu Sans, sans-serif; text-align: center;"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="font-family: DejaVu Sans, sans-serif; text-align: center;">No stock transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>