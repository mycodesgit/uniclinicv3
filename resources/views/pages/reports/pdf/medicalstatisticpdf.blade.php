<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Statistical Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px auto;
            max-width: 900px;
            color: #333;
        }

        .report-card {
            
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

        .form-group {
            display: flex;
            align-items: baseline;
        }

        .form-group label {
            font-weight: bold;
            margin-right: 8px;
            white-space: nowrap;
        }

        .form-group input {
            flex: 1;
            border: none;
            border-bottom: 1px solid #333;
            outline: none;
            padding: 2px 5px;
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

        textarea {
            width: 100%;
            height: 80px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            padding: 8px;
            font-family: inherit;
            resize: vertical;
            margin-bottom: 15px;
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

            .report-card {
                border: none;
                box-shadow: none;
                padding: 0;
            }

            textarea {
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>

    <div class="report-card">
        <h1>Medical Statistical Report</h1> <!--[cite: 1] -->

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

        <!-- I. Summary of Patient Consultations -->
        <h2>Summary of Patient Consultations</h2>
        <table>
            <thead>
                <tr>
                    <th>Nature of Consultation</th>
                    <th class="center" style="width: 15%;">Male</th>
                    <th class="center" style="width: 15%;">Female</th>
                    <th class="center" style="width: 15%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultations as $pcatId => $data)
                    <tr>
                        <td>{{ $data['label'] }}</td>
                        <td class="center">{{ $data['male'] > 0 ? $data['male'] : 0 }}</td>
                        <td class="center">{{ $data['female'] > 0 ? $data['female'] : 0 }}</td>
                        <td class="center">{{ $data['total'] > 0 ? $data['total'] : 0 }}</td>
                    </tr>
                @endforeach

                {{-- GRAND TOTAL ROW --}}
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td class="center"><strong>{{ $grandTotal['male'] }}</strong></td>
                    <td class="center"><strong>{{ $grandTotal['female'] }}</strong></td>
                    <td class="center"><strong>{{ $grandTotal['total'] }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- II. Classification of Consultations -->
        <h2>II. Classification of Consultations</h2> <!--[cite: 1] -->
        <table>
            <thead>
                <tr>
                    <th>Type of Consultation</th>
                    <th class="center" style="width: 25%;">Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultationTypes as $type)
                    <tr>
                        <td>{{ $type['label'] }}</td>
                        <td class="center">{{ $type['count'] }}</td>
                    </tr>
                @endforeach

                {{-- TOTAL ROW --}}
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td class="center"><strong>{{ $totalClassifications }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- III. Medical Services Rendered -->
        <h2>III. Medical Services Rendered</h2> <!--[cite: 1] -->
        <table>
            <thead>
                <tr>
                    <th>Service</th> <!--[cite: 1] -->
                    <th class="center" style="width: 25%;">Number</th> <!--[cite: 1] -->
                </tr>
            </thead>
            <tbody>
                {{-- Loop through services active in MedicalServicesRendered model --}}
                @foreach($servicesRenderedCounts as $service)
                    <tr>
                        <td>{{ $service['name'] }}</td>
                        <td class="center">{{ $service['count'] }}</td>
                    </tr>
                @endforeach

                {{-- Show 'Others' row if untracked/inactive IDs exist --}}
                @if($otherServicesCount > 0)
                    <tr>
                        <td>Others</td>
                        <td class="center">{{ $otherServicesCount }}</td>
                    </tr>
                @endif

                {{-- TOTAL ROW --}}
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td class="center"><strong>{{ $totalServicesRendered }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Morbidity / Diagnoses Table -->
        <h2>IV. Morbidity Report / System Diagnoses</h2>
        <table>
            <thead>
                <tr>
                    <th>Body System / Category</th>
                    <th>Diagnosis / Complaint</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($morbidityData as $category => $items)
                    @php $isFirst = true; @endphp
                    @foreach ($items as $item)
                        <tr>
                            @if ($isFirst)
                                <td rowspan="{{ count($items) }}">
                                    <strong>{{ $category }}</strong>
                                </td>
                                @php $isFirst = false; @endphp
                            @endif

                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['male'] }}</td>
                            <td>{{ $item['female'] }}</td>
                            <td><strong>{{ $item['total'] }}</strong></td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">GRAND TOTAL</th>
                    <th>{{ $morbidityGrandTotal['male'] }}</th>
                    <th>{{ $morbidityGrandTotal['female'] }}</th>
                    <th>{{ $morbidityGrandTotal['total'] }}</th>
                </tr>
            </tfoot>
        </table>

        <!-- Accidents and Injuries -->
        <h2>Accidents and Injuries</h2> <!--[cite: 1] -->
        <table>
            <thead>
                <tr>
                    <th>Nature of Injury</th> <!--[cite: 1] -->
                    <th class="center" style="width: 25%;">Number</th> <!--[cite: 1] -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Falls</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Cuts/Lacerations</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Sprains</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Burns</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Sports-related Injuries</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Vehicular Incidents</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Animal Bites</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Others</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr class="total-row">
                    <td>TOTAL</td> <!--[cite: 1] -->
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Referrals -->
        <h2>Referrals</h2> <!--[cite: 1] -->
        <table>
            <thead>
                <tr>
                    <th>Referral Facility</th> <!--[cite: 1] -->
                    <th class="center" style="width: 25%;">Number</th> <!--[cite: 1] -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>City Health Office</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Rural Health Unit</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Government Hospital</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Private Hospital</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Specialist Physician</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Dental Clinic</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Diagnostic Laboratory</td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr class="total-row">
                    <td>TOTAL</td> <!--[cite: 1] -->
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Health Programs Implemented -->
        <h2>Health Programs Implemented</h2> <!--[cite: 1] -->
        <table>
            <thead>
                <tr>
                    <th>Activity</th> <!--[cite: 1] -->
                    <th class="center" style="width: 25%;">Number Conducted</th> <!--[cite: 1] -->
                    <th class="center" style="width: 25%;">Participants</th> <!--[cite: 1] -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rabies Awareness and Prevention</td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Vaccination</td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Bloodletting Activity</td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Medical Mission</td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Substance Abuse Awareness</td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Dengue Prevention</td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>STD’s and HIV Awareness</td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
            </tbody>
        </table>

        <!-- Remarks & Text Blocks -->
        <h2>Remarks / Accomplishments</h2> <!--[cite: 1] -->
        <textarea rows="3"></textarea>

        <h2>XI. Issues and Concerns</h2> <!--[cite: 1] -->
        <textarea rows="3"></textarea>

        <h2>XII. Recommendations</h2> <!--[cite: 1] -->
        <textarea rows="3"></textarea>

        <!-- Signatures -->
        <hr style="border: 0; border-top: 1px solid #ccc; margin-top: 30px;">

        <div class="signatures-container">
            <div class="signature-block">
                <h3>Prepared by:</h3> <!--[cite: 1] -->
                <div class="signature-line"><label>Name:</label> <input type="text"></div> <!--[cite: 1] -->
                <div class="signature-line"><label>Position:</label> <input type="text"></div> <!--[cite: 1] -->
                <div class="signature-line"><label>Signature:</label> <input type="text"></div> <!--[cite: 1] -->
                <div class="signature-line"><label>Date:</label> <input type="date"></div> <!--[cite: 1] -->
            </div>

            <div class="signature-block">
                <h3>Noted by:</h3> <!--[cite: 1] -->
                <div class="signature-line"><label>Name:</label> <input type="text"></div> <!--[cite: 1] -->
                <div class="signature-line"><label>Position:</label> <input type="text"></div> <!--[cite: 1] -->
                <div class="signature-line"><label>Signature:</label> <input type="text"></div> <!--[cite: 1] -->
                <div class="signature-line"><label>Date:</label> <input type="date"></div> <!--[cite: 1] -->
            </div>
        </div>

    </div>

</body>

</html>
