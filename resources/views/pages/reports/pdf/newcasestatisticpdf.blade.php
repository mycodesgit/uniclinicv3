<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Cases Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px auto;
            max-width: 900px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        h2 {
            font-size: 16px;
            background-color: #f2f2f2;
            padding: 8px 12px;
            margin-top: 25px;
            margin-bottom: 15px;
            border-left: 4px solid #333;
            text-transform: uppercase;
        }

        .grid-info {
            width: 100%;
            margin-bottom: 25px;
            clear: both;
        }

        .info-group {
            width: 48%;
            display: inline-block;
            margin-bottom: 12px;
            vertical-align: bottom;
        }

        .info-label {
            font-weight: bold;
            font-size: 13px;
            color: #333333;
            display: inline-block;
            white-space: nowrap;
        }

        .info-value {
            display: inline-block;
            border-bottom: 1px solid #000000;
            font-size: 13px;
            padding-left: 5px;
            padding-bottom: 2px;
            min-width: 120px; /* Ensures underline exists even if value is empty */
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f9f9f9;
        }

        .center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        /* College name row inside its table */
        .college-header th {
            background-color: #f2f2f2;
            font-size: 15px;
            text-transform: uppercase;
            border-left: 4px solid #333;
            padding: 8px 12px;
        }

        /* Keep headings with tables and avoid splitting tables across pages */
        h2 {
            page-break-after: avoid;
        }

        table {
            page-break-inside: avoid;
        }

        .signatures-container {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature-block {
            width: 45%;
        }

        .signature-block h3 {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .signature-line {
            margin-bottom: 15px;
            display: flex;
        }

        .signature-line label {
            width: 80px;
            font-weight: bold;
        }

        .signature-line input {
            flex-grow: 1;
            border: none;
            border-bottom: 1px solid #333;
            outline: none;
        }

        @media print {
            body {
                background-color: #fff;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="report-card">
        <h1>New Cases Report</h1>

        <!-- Header Info -->
        <div class="grid-info">
            <div class="info-group">
                <span class="info-label">Reporting Period:</span>
                <span class="info-value">{{ $reportingPeriodLabel }}</span>
            </div>
            <div class="info-group">
                <span class="info-label">Month/Quarter/Year:</span>
                <span class="info-value">{{ $formattedPeriodValue }}</span>
            </div>
            <div class="info-group">
                <span class="info-label">Prepared by:</span>
                <span class="info-value">{{ $preparedBy }}</span>
            </div>
            <div class="info-group">
                <span class="info-label">Position:</span>
                <span class="info-value">{{ $position }}</span>
            </div>
        </div>

        <!-- New Cases by College -->
        <h2>Summary of New Cases by College</h2>

        @forelse($collegeRows as $row)
            {{-- One table per college, college name inside the table --}}
            <table>
                <thead>
                    <tr>
                        <th colspan="4">{{ trim($row['abbr'] . ' - ' . $row['name'], ' -') }}</th>
                    </tr>
                    <tr>
                        <th>Programs</th>
                        <th class="center" style="width: 15%;">Total</th>
                        <th class="center" style="width: 15%;">Male</th>
                        <th class="center" style="width: 15%;">Female</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($row['programs']) > 0)
                        {{-- Programs (progAcronym) under the college --}}
                        @foreach($row['programs'] as $program)
                            <tr>
                                <td>{{ $program['acronym'] }}</td>
                                <td class="center">{{ $program['total'] }}</td>
                                <td class="center">{{ $program['male'] }}</td>
                                <td class="center">{{ $program['female'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="center">No new cases recorded for this college.</td>
                        </tr>
                    @endif

                    {{-- College Subtotal Row --}}
                    <tr class="total-row">
                        <td><strong>TOTAL</strong></td>
                        <td class="center"><strong>{{ $row['total'] }}</strong></td>
                        <td class="center"><strong>{{ $row['male'] }}</strong></td>
                        <td class="center"><strong>{{ $row['female'] }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @empty
            <table>
                <tbody>
                    <tr>
                        <td colspan="4" class="center">No new cases recorded for this period.</td>
                    </tr>
                </tbody>
            </table>
        @endforelse

        {{-- Overall Total --}}
        <h2>Overall Total</h2>
        <table>
            <thead>
                <tr>
                    <th>Summary</th>
                    <th class="center" style="width: 15%;">Total</th>
                    <th class="center" style="width: 15%;">Male</th>
                    <th class="center" style="width: 15%;">Female</th>
                </tr>
            </thead>
            <tbody>
                <tr class="total-row">
                    <td><strong>ALL COLLEGES</strong></td>
                    <td class="center"><strong>{{ $newCaseTotal['total'] }}</strong></td>
                    <td class="center"><strong>{{ $newCaseTotal['male'] }}</strong></td>
                    <td class="center"><strong>{{ $newCaseTotal['female'] }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Signatures -->
        <hr style="border: 0; border-top: 1px solid #ccc; margin-top: 30px;">

        <div class="signatures-container">
            <div class="signature-block">
                <h3>Prepared by:</h3>
                <div class="signature-line"><label>Name:</label> <input type="text" value="{{ $preparedBy ?? '' }}"></div>
                <div class="signature-line"><label>Position:</label> <input type="text" value="{{ $position ?? '' }}"></div>
                <div class="signature-line"><label>Signature:</label> <input type="text"></div>
                <div class="signature-line"><label>Date:</label> <input type="text" value="{{ date('F d, Y') }}"></div>
            </div>

            <div class="signature-block">
                <h3>Noted by:</h3>
                <div class="signature-line"><label>Name:</label> <input type="text"></div>
                <div class="signature-line"><label>Position:</label> <input type="text"></div>
                <div class="signature-line"><label>Signature:</label> <input type="text"></div>
                <div class="signature-line"><label>Date:</label> <input type="date"></div>
            </div>
        </div>

    </div>

</body>

</html>
