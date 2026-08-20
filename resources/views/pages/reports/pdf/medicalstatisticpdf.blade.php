<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Statistical Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px auto;
            padding: 20px;
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
        <h2>Morbidity Report / System Diagnoses</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Body System</th> <!--[cite: 1] -->
                    <th>Diagnosis/Condition</th> <!--[cite: 1] -->
                    <th class="center" style="width: 10%;">Male</th> <!--[cite: 1] -->
                    <th class="center" style="width: 10%;">Female</th> <!--[cite: 1] -->
                    <th class="center" style="width: 10%;">Total</th> <!--[cite: 1] -->
                </tr>
            </thead>
            <tbody>
                <!-- Respiratory -->
                <tr>
                    <td rowspan="7"><strong>Respiratory System</strong></td>
                    <td>Upper Respiratory Tract Infection (URTI)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Lower Respiratory Tract Infection</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Influenza/Flu-like Illness</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Bronchial Asthma</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Allergic Rhinitis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Hyperventilation</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Pneumonia</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Cardiovascular -->
                <tr>
                    <td rowspan="6"><strong>Cardiovascular System</strong></td>
                    <td>Hypertension</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Hypotension</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Chest Pain</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Palpitations</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Tachycardia</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Syncope/Fainting</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Gastrointestinal -->
                <tr>
                    <td rowspan="6"><strong>Gastrointestinal System</strong></td>
                    <td>Acute Gastroenteritis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Abdominal Pain</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Hyperacidity/Gastritis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Diarrhea</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Constipation</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Nausea/Vomiting</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Musculoskeletal -->
                <tr>
                    <td rowspan="6"><strong>Musculoskeletal System</strong></td>
                    <td>Muscle Pain (Myalgia)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Low Back Pain</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Neck Pain</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Joint Pain (Arthralgia)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Sprain/Strain</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Sports Injury</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Neurologic -->
                <tr>
                    <td rowspan="5"><strong>Neurologic System</strong></td>
                    <td>Headache</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Migraine</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Dizziness/Vertigo</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Loss of Consciousness</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Seizure</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Dermatologic -->
                <tr>
                    <td rowspan="9"><strong>Dermatologic (Skin)</strong></td>
                    <td>Dermatitis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Skin Allergy</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Fungal Infection</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Scabies</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Cellulitis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Wounds/Lacerations</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Burns</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Animal/Insect Bites</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Boils</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Eye -->
                <tr>
                    <td rowspan="4"><strong>Eye (Ophthalmologic)</strong></td>
                    <td>Conjunctivitis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Eye Irritation</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Eye Injury</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Blurred Vision</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- ENT / Genitourinary -->
                <tr>
                    <td rowspan="7"><strong>Ear, Nose and Throat (ENT)</strong></td>
                    <td>Ear Infection (Otitis)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Ear Pain</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Sore Throat (Pharyngitis)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Tonsillitis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Epistaxis (Nosebleed)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Dysuria</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Hematuria</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Reproductive System (Female) -->
                <tr>
                    <td rowspan="3"><strong>Reproductive System (Female)</strong></td>
                    <td>Dysmenorrhea</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Menstrual Irregularities</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Amenorrhea</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Endocrine/Metabolic -->
                <tr>
                    <td rowspan="3"><strong>Endocrine/Metabolic System</strong></td>
                    <td>Diabetes Mellitus</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Hypoglycemia</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Hyperglycemia</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Mental Health -->
                <tr>
                    <td rowspan="3"><strong>Mental and Behavioral Health</strong></td>
                    <td>Anxiety</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Panic Attack</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Sleep Disturbance</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Dental -->
                <tr>
                    <td rowspan="4"><strong>Dental/Oral Health</strong></td>
                    <td>Toothache</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Dental Caries</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Gingivitis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Oral Ulcer</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->

                <!-- Communicable Diseases -->
                <tr>
                    <td rowspan="7"><strong>Communicable Diseases</strong></td>
                    <td>COVID-19</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Dengue Fever</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Chickenpox</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Measles</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Hand, Foot and Mouth Disease</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Mumps</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
                <tr>
                    <td>Herpes Zoster</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> <!--[cite: 1] -->
            </tbody>
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
