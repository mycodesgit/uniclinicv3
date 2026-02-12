<!DOCTYPE html>
<html>
<head>
    <title>PRE-ENTRANCE HEALTH EXAMINATION REPORT</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body{
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .table-responsive {
            overflow-x: auto;
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table tr {
            margin: 0px;
        }

        .table th,
        .table td {
            padding: 2px;
            overflow: hidden;
        }

        th{
            height: 15px !important;
        }
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .border {
            border: 1px solid black;
        }

        .border-b {
            border-bottom: 1px solid black !important;
        }

        .tr-b {
            border-bottom: 1px solid black !important;
        }

        .w-100 {
            width: 100%
        }

        .td-b1 {
            border-bottom: 1px solid black;
            position: relative;
        }

        .period{
            color: white;
        }

        .bordered{
            border: 1px solid black;
        }

        [data-chk="chk"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 14px;
            height: 14px;
            border: none;
            outline: none;
            background-color: transparent;
            cursor: pointer;
            margin-bottom: 4px;
        }

        [data-chk="chk"]::before {
            content: '\2713';
            display: none; /* Hide by default */
            font-size: 18px; 
            color: #000;
        }

        [data-chk="chk"]:checked::before {
            display: inline-block; /* Show when checked */
        }
    </style>
</head>
<body>
    <div style="width: 100%; text-align: center;">
        <img src="{{ public_path("assets/img/pdf/pehe-header.png") }}" width="80%" style="margin-top: -60px;" alt="" srcset="">
    </div>
    <span style="font-size: 8px; margin: 0px;">(Please write legibly and use black pen only)</span>
    <h5 style="margin-top: -2px;">PERSONAL INFORMATION</h5>
    <div class="table-responsive" style="border: 1px solid black; margin-top: -18px;">
        <table class="table">
            <tr class="tr-b">
                <td class="text-left">Name:</td>
                <td class="text-center"><b>{{ strtoupper($patients->lname) }} {{ strtoupper($patients->ext_name) }}</b></td>
                <td class="text-center"><b>{{ strtoupper($patients->fname) }}</b></td>
                <td class="text-center"><b>{{ strtoupper($patients->mname) }}</b></td>
                <td></td>
            </tr>
            <tr style="font-size: 9px;">
                <td></td>
                <td class="text-center">(Last)</td>
                <td class="text-center">(First)</td>
                <td class="text-center">(Middle)</td>
                <td class="text-center"></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="53">Date of Birth:</td>
                <td><div class="tr-b w-100 text-center"><b>{{ \Carbon\Carbon::parse($patients->bday)->format('F d, Y') }}</b><span class="period">.</span></div></td>
                <td width="18">Age:</td>
                <td><div class="tr-b w-100 text-center"><b>{{ \Carbon\Carbon::parse($patients->bday)->age }}</b> <span class="period">.</span></div></td>
                <td width="18">Sex:</td>
                <td><div class="tr-b w-100 text-center"><b>{{ $patients->gender }}</b> <span class="period">.</span></div></td>
                <td width="48">Civil Status:</td>
                <td><div class="tr-b w-100 text-center"><b>{{ $patients->civil_status }}</b> <span class="period">.</span></div></td>
                <td width="45">Nationality:</td>
                <td><div class="tr-b w-100 text-center"><b>{{ ucfirst($patients->stud_nation) }}</b> <span class="period">.</span></div></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="64">Home Address:</td>
                <td><div class="tr-b w-100"><b>{{ ucwords(strtolower($patients->address), " ()-,") }}</b><span class="period">.</span></div></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="67">Contact number:</td>
                <td><div class="tr-b w-100"><b>{{ $patients->contact }}</b> <span class="period">.</span></div></td>
                <td width="18">Religion:</td>
                <td><div class="tr-b w-100"><b>{{ ucwords(strtolower($patients->religion)) }}</b><span class="period">.</span></div></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="20">College/Department:</td>
                <td><div class="tr-b w-100 text-left"><b>{{ ucwords(strtolower($patients->college_name)) }}</b> <span class="period">.</span></div></td>
                <td width="20">Course/Year:</td>
                <td><div class="tr-b w-100 text-left"><b> {{ $patients->course }}</b> <span class="period">.</span></div></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="113">Name of Parents/ Guardian:</td>
                <td>
                    <div class="tr-b w-100">
                        <b>
                            {{ ucwords(strtolower($patients->stud_father 
                                ?? $patients->stud_mother 
                                ?? $patients->stud_guardian)) }}
                            <span class="period">.</span>
                        </b>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="37">Address:</td>
                <td><div class="tr-b w-100"><b>{{ ucwords(strtolower($patients->address), " ()-,") }}</b><span class="period">.</span></div></td>
            </tr>
        </table>
        <table class="table" style="margin-bottom: 10px;">
            <tr>
                <td width="80">Contact Number/s:</td>
                <td><div class="tr-b w-100 text-center"><b>{{ $patients->guardian_contact }}</b> <span class="period">.</span></div></td>
                <td width="15">Occupation:</td>
                <td><div class="tr-b w-100 text-center"><b>{{ $patients->guardian_occup }}</b> <span class="period">.</span></div></td>
            </tr>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="3" class="bordered text-center" width="140">ANTHROPOMETRICS</th>
                    <td class="" style="border-top: 1px solid black;">
                        Height: 
                        <b>
                            <span class="td-b1 text-center" style="display: inline-block; width: 50px;">
                                @php
                                    $heightInches = 68;
                                    $feet = floor($heightInches / 12);
                                    $inches = $heightInches % 12;
                                @endphp
                                {{ $feet }}'{{ $inches }}"
                            </span> ft
                        </b>
                    </td>
                    <th rowspan="3" class="bordered text-center"  width="110">VITAL SIGNS</th>
                    <td class="" style="border-top: 1px solid black;">
                        Temp:  
                        <b>
                            <span class="td-b1 text-center" style="display: inline-block; width: 50px;"> {{ $patients->temp }} &deg;C.</span>
                        </b> 
                        C BP:  
                        <b>
                            <span class="td-b1 text-center" style="display: inline-block; width: 50px;"> {{ $patients->bp }} </span>
                        </b>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Weight:  
                        <b>
                            <span class="td-b1 text-center" style="display: inline-block; width: 50px;">  {{ $patients->weight_kg }} </span>
                            Kg
                        </b>
                    </td>
                    <td>
                        PR:  
                        <b>
                            <span class="td-b1 text-center" style="display: inline-block; width: 50px;"> {{ $patients->pr }} </span>/min RR:  
                            <b><span class="td-b1 text-center" style="display: inline-block; width: 50px;"> {{ $patients->rr }} </span>/min
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid black;">
                        BMI:  
                        <b>
                            <span class="td-b1 text-center" style="display: inline-block; width: 30px;"> {{ $patients->bmi }} </span>;<span class="td-b1 text-center" style="display: inline-block; width: 60px; font-size: 9px;"> 
                                {{ ($patients->bmi < 16.0) ? '(Severely Underweight)' : '' }} 
                                {{ ($patients->bmi >= 16.0 && $patients->bmi <= 18.4) ? '(Underweight)' : '' }} 
                                {{ ($patients->bmi >= 18.5 && $patients->bmi <= 24.9) ? '(Normal)' : '' }} 
                                {{ ($patients->bmi >= 25.0 && $patients->bmi <= 29.9) ? '(Overweight)' : '' }} 
                                {{ ($patients->bmi >= 30.0 && $patients->bmi <= 34.9) ? '(Moderately Obese)' : '' }} 
                                {{ ($patients->bmi >= 35.0 && $patients->bmi <= 39.9) ? '(Severely Obese)' : '' }} 
                                {{ ($patients->bmi >= 40.0) ? '(Morbidly Obese' : '' }}                         
                            </span>
                        </b>
                    </td>
                    <td style="border-bottom: 1px solid black;"></td>
                </tr>
            </tbody>
        </table>
        
    </div>
    <h5 style="margin-top: -0.3px;">MEDICAL HISTORY</h5>
    <div class="table-responsive" style="border: 1px solid black; margin-top: -18px;">
        <table class="table">
            <thead>
                <tr>
                    <th class="bordered text-center" width="108">DISEASE</th>
                    <th class="bordered text-center" width="20"></th>
                    <th class="bordered text-center">Speccific Disease/<br>Remarks</th>
                    <th class="bordered text-center" colspan="4" width="100">Hospital <br> Confinement</th>
                    <th class="bordered text-center">Date/s of Hospitalization, if confined</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bordered">Allergy (Food, Medicine)</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[0] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[0] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[0] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[0] == 1) ? (explode(',', $patients->hospital_confine)[0] == 0) ? 'checked' : '' : '' }}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[0]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[0])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[0]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[0])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">COVID-19 Infection</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[1] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[1] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[1] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[1] == 1) ? (explode(',', $patients->hospital_confine)[1] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[1]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[1])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[1]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[1])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Nosebleed</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[2] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[2] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[2] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[2] == 1) ? (explode(',', $patients->hospital_confine)[2] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[2]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[2])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[2]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[2])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Dengue Fever</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[3] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[3] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[3] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[3] == 1) ? (explode(',', $patients->hospital_confine)[3] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[3]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[3])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[3]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[3])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Rheumatic Fever</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[4] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[4] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[4] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[4] == 1) ? (explode(',', $patients->hospital_confine)[4] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[4]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[4])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[4]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[4])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Typhoid Fever</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[5] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[5] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[5] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[5] == 1) ? (explode(',', $patients->hospital_confine)[5] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[5]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[5])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[5]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[5])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Arthritis</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[6] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[6] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[6] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[6] == 1) ? (explode(',', $patients->hospital_confine)[6] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[6]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[6])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[6]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[6])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Urinary Tract Infect, STD</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[7] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[7] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[7] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[7] == 1) ? (explode(',', $patients->hospital_confine)[7] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[7]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[7])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[7]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[7])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Amoebiasis</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[8] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[8] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[8] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[8] == 1) ? (explode(',', $patients->hospital_confine)[8] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[8]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[8])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[8]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[8])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Hyperacidity</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[9] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[9] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[9] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[9] == 1) ? (explode(',', $patients->hospital_confine)[9] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[9]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[9])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[9]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[9])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Asthma</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[10] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[10] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[10] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[10] == 1) ? (explode(',', $patients->hospital_confine)[10] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[10]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[10])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[10]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[10])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Hepatitis A/B</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[11] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[11] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[11] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[11] == 1) ? (explode(',', $patients->hospital_confine)[11] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[11]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[11])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[11]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[11])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Heart Disease</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[12] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[12] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[12] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[12] == 1) ? (explode(',', $patients->hospital_confine)[12] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[12]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[12])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[12]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[12])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Mumps</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[13] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[13] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[13] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[13] == 1) ? (explode(',', $patients->hospital_confine)[13] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[13]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[13])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[13]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[13])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Tuberculosis, Pneumonia</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[14] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[14] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[14] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[14] == 1) ? (explode(',', $patients->hospital_confine)[14] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[14]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[14])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[14]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[14])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Chicken Pox</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[15] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[15] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[15] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[15] == 1) ? (explode(',', $patients->hospital_confine)[15] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[15]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[15])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[15]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[15])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Measles</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[16] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[16] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[16] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[16] == 1) ? (explode(',', $patients->hospital_confine)[16] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[16]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[16])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[16]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[16])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Fainting Spells. Sezure</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[17] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[17] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[17] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[17] == 1) ? (explode(',', $patients->hospital_confine)[17] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[17]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[17])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[17]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[17])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Hernia</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[18] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[18] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[18] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[18] == 1) ? (explode(',', $patients->hospital_confine)[18] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[18]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[18])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[18]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[18])->format('F d, Y') : ''  }}</b></td>
                </tr>
                <tr>
                    <td class="bordered">Thyroid Disease, Cancer</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[19] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center"><b>{{ explode(',', $patients->disease_rem)[19] }}</b></td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->hospital_confine)[19] == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Yes</td>
                    <td class="bordered text-center"><input type="checkbox" data-chk="chk" id="checkbox" {{ (explode(',', $patients->disease)[19] == 1) ? (explode(',', $patients->hospital_confine)[19] == 0) ? 'checked' : '' : ''}}></td>
                    <td class="bordered text-center">No</td>
                    <td class="bordered text-center"><b>{{ ((explode(',', $patients->date_hospitaliz)[19]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz)[19])->format('F d, Y'). '-'  : '' }} {{ ((explode(',', $patients->date_hospitaliz1)[19]) != '') ? \Carbon\Carbon::parse(explode(',', $patients->date_hospitaliz1)[19])->format('F d, Y') : ''  }}</b></td>
                </tr>
            </tbody>
        </table>
        
        <table class="table">
            <tbody>
                <tr>
                    <td class="bordered text-center" width="132" rowspan="3"><b>IMMUNIZTIONS</td>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[0]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">Chicken Pox</td>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[1]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">Hepatitis A</td>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[2]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">Influenza</td>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[3]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">Tetanus Toxoid</td>
                </tr>
                <tr>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[4]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">HPV Vaccine</td>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[5]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">Hepatitis B</td>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[6]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">Pneumonia</td>
                    <td class="bordered text-center" width="20"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->immunization1)[7]  == "1") ?  'checked' : '' }}></td>
                    <td class="bordered text-center">Rabies</td>
                </tr>
                <tr>
                    <td class="bordered text-center" width="20"></td>
                    <td colspan="7">
                        <div style="margin-top: 5px; margin-bottom: 5px;">
                            <b>COVID-19 Vaccine:</b> <br>1st Dose <span class="td-b1 text-center" style="display: inline-block; width: 170px;"><b>{{ explode(',', $patients->immunization2)[0] }} - {{ explode(',', $patients->immunization2)[1] }}</span> 2nd: <span class="td-b1 text-center" style="display: inline-block; width: 170px;"><b>{{ explode(',', $patients->immunization2)[2] }} - {{ explode(',', $patients->immunization2)[3] }}</span><br>
                            <b>Booster Dose</b> <br>1st Dose <span class="td-b1 text-center" style="display: inline-block; width: 170px;"><b>{{ explode(',', $patients->immunization2)[4] }} - {{ explode(',', $patients->immunization2)[5] }}</span> 2nd: <span class="td-b1 text-center" style="display: inline-block; width: 170px;"><b>{{ explode(',', $patients->immunization2)[6] }} - {{ explode(',', $patients->immunization2)[7] }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="bordered text-center" width="132"><b>Smoking</td>
                    <td class="bordered text-center" width="20"></td>
                    <td class="bordered" colspan="7">
                        <div style="margin-top: 10px;">
                            <span class="td-b1 text-center" style="display: inline-block; width: 120px;"><b>{{ explode(',', $patients->smoking)[0] }}</span> (sticks/day for <span class="td-b1 text-center" style="display: inline-block; width: 50px;">{{ explode(',', $patients->smoking)[1] }}</span> years) 
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="bordered text-center" width="132"><b>Drinking</td>
                    <td class="bordered text-center" width="20"></td>
                    <td class="bordered" colspan="7">
                        <div style="margin-top: 10px;">
                            <span class="td-b1 text-center" style="display: inline-block; width: 120px;">{{ explode(',', $patients->drinking)[0] }}</span> (beer per <span class="td-b1 text-center" style="display: inline-block; width: 50px;">{{ explode(',', $patients->drinking)[1] }}</span>;<span class="td-b1 text-center" style="display: inline-block; width: 50px;">{{ explode(',', $patients->drinking)[2] }}</span>shots per <span class="td-b1 text-center" style="display: inline-block; width: 50px;">{{ explode(',', $patients->drinking)[3] }}</span>) 
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th class="bordered text-center" width="132" rowspan="2">MENSTRUAL HISTORY</th>
                    <th class="bordered text-center">Menarche</th>
                    <th class="bordered text-center">Duration</th>
                    <th class="bordered text-center" colspan="4">Interval</th>
                    <th class="bordered text-center" width="80">Pads Used per Day</th>
                </tr>
                <tr>
                    <td class="bordered text-center">{{ $patients->Menarche }}</td>
                    <td class="bordered text-center">{{ $patients->Duration }}</td>
                    <td class="bordered text-center"><input type="checkbox" id="checkbox" {{ ($patients->studinterval == 1) ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Regular</td>
                    <td class="bordered text-center"><input type="checkbox" id="checkbox" {{ ($patients->studinterval == 0 && $patients->sex == 'Female') ? 'checked' : '' }}></td>
                    <td class="bordered text-center">Irregular</td>
                    <td class="bordered text-center">{{ $patients->pads_use }}</td>
                </tr>
            </thead>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th class="bordered text-center" width="132">MENSTRUAL SYMPTOMS</th>
                    <td class="bordered text-center" width="221">{{ ucfirst($patients->mens_symp) }}</td>
                    <td class="bordered text-center" width="30">LMP</td>
                    <td class="bordered text-center">{{ \Carbon\Carbon::parse($patients->lmp)->format('F j, Y') }}</td>
                </tr>
            </thead>
        </table>
    </div>
    <p style="font-size: 12px; margin-top: -2px;"><b>I hereby certify that the above history is true to best of my knowledge. </b></p>
    <table class="table" style="margin-top: 15px; margin-bottom: -17px;">
        <tr>
            <td class="text-center" width="180"><span class="td-b1 text-center" style="display: inline-block; width: 100%;">{{ strtoupper($patients->fname) }} {{ strtoupper($patients->lname) }} {{ strtoupper($patients->ext_name) }} {{ strtoupper($patients->mname) }}</span><b>Student's Signature</td>
            <td class="text-center" width="180"></td>
            <td class="text-center" width=""><span class="td-b1 text-center" style="display: inline-block; width: 100%;">{{ \Carbon\Carbon::now()->format('F j, Y') }}</span><b><span style="color: white;">..........</span>Date<span style="color: white;">..........</span></td>
        </tr>
    </table>
    <table class="table" spellcheck="margin-top: -10px;">
        <tr>
            <td class="text-center" style="font-size: 10px;"><br><br><br>Document Control Code: CPSU-F-MDHU-01 Effective Date: 09/12/20218 Page No.: 1 of 2</td>
        </tr>
    </table>
    <table class="table" style="font-size: 15px;">
        <tr>
            <td class="bordered text-center" width="38%">{{ strtoupper($patients->lname) }}</td>
            <td class="bordered text-center" width="38%">{{ strtoupper($patients->fname) }} {{ strtoupper($patients->ext_name) }}</td>
            <td class="bordered text-center" width="38%">{{ strtoupper($patients->mname) }}</td>
            <td class="bordered text-center" width="16%">{{ strtoupper($patients->age) }}</td>
        </tr>
        <tr>
            <th class="text-center">LAST NAME</th>
            <th class="text-center">FIRST NAME</th>
            <th class="text-center">MIDDLE NAME</th>
            <th class="text-center">AGE</th>
        </tr>
    </table>
    <table class="table" style="font-size: 15px; ">
        <thead>
            <tr>
                <th class="bordered text-center" colspan="7">PHYSICAL EXAMINATION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="bordered text-center" width="155">FINDING</th>
                <th class="bordered text-center" width="30">E/N</th>
                <th class="bordered text-center" colspan="4">FINDING/S</th>
                <th class="bordered text-center" width="110">DESCRIPTION AND OTHER FINDINGS</th>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">SKIN</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[0]  == 1 || explode(',', $patients->findings_pexam)[1]  == 1) ?  '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[0]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Discoloration</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[1]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Congential Marks</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[2]  == 1 || explode(',', $patients->findings_pexam)[3]  == 1) ?  '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[2]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Lesion</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[3]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
            </tr>
            <tr>
                <th class="bordered text-center">HEAD</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[4]  == 1 || explode(',', $patients->findings_pexam)[5]  == 1) ?  '' : 'checked' }}></td>
               <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[4]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
               <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[5]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Mass/Nodules</td>
                <td class="bordered text-center"></td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">EYES</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[6]  == 1 || explode(',', $patients->findings_pexam)[7]  == 1) ?  '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[6]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[7]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Discharges</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[8]  == 1 || explode(',', $patients->findings_pexam)[9]  == 1) ?  '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[8]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Swelling</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[9]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Pale/Red Conjunctiva</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">EARS</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[10]  == 1 || explode(',', $patients->findings_pexam)[11]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[10]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Hearing Acuity</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[11]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[12]  == 1 || explode(',', $patients->findings_pexam)[13]  == 1) ?  '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[12]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">R <span class="td-b1 text-center" style="display: inline-block; width: 30px;">  </span> L <span class="td-b1 text-center" style="display: inline-block; width: 30px;">  </span> </td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[13]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Discharge</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">NOSE</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[14]  == 1 || explode(',', $patients->findings_pexam)[15]  == 1) ? '' : 'checked' }}></td>
               <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[14]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
               <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[15]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Lesion</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[16]  == 1 || explode(',', $patients->findings_pexam)[17]  == 1) ? '' : 'checked' }}></td>
               <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[16]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Bleeding</td>
               <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[17]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Discharge</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">MOUTH AND TONGUE</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[18]  == 1 || explode(',', $patients->findings_pexam)[19]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[18]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Inflamation</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[19]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Lesion</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[20]  == 1 || explode(',', $patients->findings_pexam)[21]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[20]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Tongue Deviation</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[21]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">NECK & LYMPH NODES</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[22]  == 1 || explode(',', $patients->findings_pexam)[23]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[22]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Rigidity</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[23]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Tenderness</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[24]  == 1 || explode(',', $patients->findings_pexam)[25]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[24]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Mass/Swelling</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[25]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Fistula</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">HEART</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[26]  == 1 || explode(',', $patients->findings_pexam)[27]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[26]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Tachucardia</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[27]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Murmur</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[28]  == 1 || explode(',', $patients->findings_pexam)[29]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[28]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Bradycardia</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[29]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Irregular Beat</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">CHEST</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[30]  == 1 || explode(',', $patients->findings_pexam)[31]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[30]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Tenderness</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[31]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Retraction</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[32]  == 1 || explode(',', $patients->findings_pexam)[33]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[32]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Bulges</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[33]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">LUNGS</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[34]  == 1 || explode(',', $patients->findings_pexam)[35]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[34]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Wheezing</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[35]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Crackles</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[36]  == 1 || explode(',', $patients->findings_pexam)[37]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[36]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Rales</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[37]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center"></td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">BREAST & AXILLA</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[38]  == 1 || explode(',', $patients->findings_pexam)[39]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[38]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Dimpling</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[39]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Mass/Nodules</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[40]  == 1 || explode(',', $patients->findings_pexam)[41]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[40]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Enlarge lymph Nodes</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[41]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Discharges (Nipples)</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">ABDOMEN</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[42]  == 1 || explode(',', $patients->findings_pexam)[43]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[42]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Striae</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[43]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Mass/Nodules</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[44]  == 1 || explode(',', $patients->findings_pexam)[45]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[44]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Tenderness</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[45]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Distention</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">BACK & SHOULDERS</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[46]  == 1 || explode(',', $patients->findings_pexam)[47]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[46]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Lordosis</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[47]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Scliosis</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[48]  == 1 || explode(',', $patients->findings_pexam)[49]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[48]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Kyphosis</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[49]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
            </tr>
            <tr>
                <th class="bordered text-center" rowspan="2">EXTRMITES</th>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[50]  == 1 || explode(',', $patients->findings_pexam)[51]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[50]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Deformity</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[51]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Temors</td>
                <td class="bordered text-center" rowspan="2"></td>
            </tr>
            <tr>
                <td class="bordered text-center"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[52]  == 1 || explode(',', $patients->findings_pexam)[53]  == 1) ? '' : 'checked' }}></td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[52]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Clubbing of nails</td>
                <td class="bordered text-center" width="15"><input type="checkbox" data-chk="chk" {{ (explode(',', $patients->findings_pexam)[53]  == 1) ?  'checked' : '' }}></td>
                <td class="bordered text-center">Lesion</td>
            </tr>
            <tr>
                <th class="bordered text-center">OTHER SIGNIFICANT FINDINGS</th>
                <td class="bordered text-left" colspan="6"><p>{{ $patients->other_find }}</p></td>
            </tr>
            <tr style="border-width: 1px 1px 0 1px; border-style: solid;">
                <td><br><input type="checkbox" id="checkbox1" style="transform: scale(1.5); margin-bottom: -5px; padding-left:2px;" {{ ($patients->pexam_remarks == 1) ?  'checked' : '' }}> Fit for enrollment</td>
                <td colspan="3"><br><input type="checkbox" id="checkbox1" style="transform: scale(1.5); margin-bottom: -5px;" {{ ($patients->pexam_remarks == 2) ?  'checked' : '' }}> Not fit for enrollment</td>
                <td colspan="2"><br><input type="checkbox" id="checkbox1" style="transform: scale(1.5); margin-bottom: -5px;" {{ ($patients->pexam_remarks == 3) ?  'checked' : '' }}> Pending; reasons</td>
                <td ></td>
            </tr>
            <tr style="border-width: 0px 1px 1px 1px; border-style: solid;">
                <td colspan="7" style="text-align: right; height: 50px;">
                    <span class="td-b1 text-center" style="display: inline-block; width: 50%;"></span>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="text-align: right; height: 150px;">
                    <span class="td-b1 text-center" style="display: inline-block; width: 51%;"><b>KRISTINE C. DURAN, RN, MAN</span><br>
                    <span style="font-size: 12px; padding-right: 11px;">Name and Signature of Examining Registedred Nurse/Physician
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table" style="margin-top: 90px;">
        <tr>
            <td class="text-center" style="font-size: 12px;"><br><br><br>Document Control Code: CPSU-F-MDHU-01 Effective Date: 09/12/20218 Page No.: 2 of 2</td>
        </tr>
    </table>
</body>
</html>
