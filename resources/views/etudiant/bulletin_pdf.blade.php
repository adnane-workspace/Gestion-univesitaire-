<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin de notes</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1f2937; margin: 0; padding: 0; }
        .page { padding: 30px; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px; }
        .header .brand { text-align: left; }
        .header h1 { margin: 0; font-size: 22px; letter-spacing: 0.04em; }
        .header p { margin: 6px 0 0; font-size: 10px; color: #4b5563; }
        .logo { width: 100px; height: auto; border-radius: 10px; }
        .title { text-align: center; margin-top: 30px; margin-bottom: 25px; font-size: 18px; letter-spacing: 0.08em; }
        .student-details, .summary, .table-section { margin-bottom: 20px; }
        .student-details table, .summary table, .grades table, .absences table { width: 100%; border-collapse: collapse; }
        .student-details td, .summary td, .grades th, .grades td, .absences th, .absences td { padding: 8px 10px; border: 1px solid #e5e7eb; }
        .student-details .label, .summary .label { width: 35%; color: #6b7280; font-size: 11px; }
        .student-details .value, .summary .value { font-weight: 700; color: #111827; }
        .grades th, .absences th { background: #f3f4f6; font-weight: 700; font-size: 11px; text-align: left; }
        .grades td, .absences td { font-size: 11px; }
        .grades .grade-badge { display: inline-block; padding: 3px 7px; border-radius: 8px; font-size: 11px; font-weight: 700; background: #ecfdf5; color: #166534; }
        .grades .grade-badge.low { background: #fef2f2; color: #991b1b; }
        .footer { margin-top: 30px; font-size: 10px; color: #6b7280; text-align: center; }
        .section-heading { margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #111827; }
    </style>
</head>
<body>
<div class="page">
    <div class="header" style="justify-content:center;">
        @if($logo)
            <img src="data:image/png;base64,{{ $logo }}" alt="Logo UPF" class="logo" style="width:180px; height:auto;">
        @else
            <div style="width:140px;height:140px;background:#e5e7eb;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:12px;color:#6b7280;">LOGO</div>
        @endif
    </div>

    <div class="title" style="margin-top: 10px;">BULLETIN DE NOTES</div>

    <div class="student-details">
        <table>
            <tr>
                <td class="label">Nom complet</td>
                <td class="value">{{ $student->getFullNameAttribute() }}</td>
                <td class="label">Matricule</td>
                <td class="value">{{ $student->student_id_number }}</td>
            </tr>
            <tr>
                <td class="label">Filière</td>
                <td class="value">{{ $student->filiere->name ?? 'N/A' }}</td>
                <td class="label">Email</td>
                <td class="value">{{ $student->email }}</td>
            </tr>
            <tr>
                <td class="label">Date de naissance</td>
                <td class="value">{{ $student->birth_date?->format('d/m/Y') ?? 'N/A' }}</td>
                <td class="label">Adresse</td>
                <td class="value">{{ $student->address ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td class="label">Année académique</td>
                <td class="value">2024-2025</td>
                <td class="label">Moyenne générale</td>
                <td class="value">{{ number_format($gpa, 2) }} / 20</td>
            </tr>
        </table>
    </div>

    <div class="table-section grades">
        <div class="section-heading">Notes par élément</div>
        <table>
            <thead>
            <tr>
                <th>Module</th>
                <th>Élément</th>
                <th>Note</th>
                <th>Session</th>
                <th>Coefficient</th>
            </tr>
            </thead>
            <tbody>
            @forelse($grades as $grade)
                <tr>
                    <td>{{ $grade->moduleElement->module->name ?? 'N/A' }}</td>
                    <td>{{ $grade->moduleElement->name ?? 'N/A' }}</td>
                    <td>
                        <span class="grade-badge {{ $grade->score < 10 ? 'low' : '' }}">{{ number_format($grade->score, 1) }}</span>
                    </td>
                    <td>{{ ucfirst($grade->session) }}</td>
                    <td>{{ $grade->moduleElement->coefficient ?? 1.0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 15px; color:#6b7280;">Aucune note disponible.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-section absences">
        <div class="section-heading">Absences</div>
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Module</th>
                <th>Salle</th>
                <th>Professeur</th>
                <th>Justifiée</th>
            </tr>
            </thead>
            <tbody>
            @forelse($absences as $absence)
                <tr>
                    <td>{{ $absence->date?->format('d/m/Y') ?? 'N/A' }}</td>
                    <td>{{ $absence->schedule->module->name ?? 'N/A' }}</td>
                    <td>{{ $absence->schedule->room->name ?? 'N/A' }}</td>
                    <td>{{ optional($absence->schedule->professor)->last_name ?? 'N/A' }}</td>
                    <td>{{ $absence->excused ? 'Oui' : 'Non' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 15px; color:#6b7280;">Aucune absence enregistrée.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Document généré automatiquement par l’application universitaire. Toutes les informations sont basées sur les données enregistrées dans le système.
    </div>
</div>
</body>
</html>
