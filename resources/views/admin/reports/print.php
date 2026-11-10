<?php
// Calculate Overall Average and Grade for the Summary Row
$overallAverage = $totalSubjects > 0 ? ($totalAggregate / $totalSubjects) : 0;
$overallAverageRounded = number_format($overallAverage, 1);

// Determine Overall Grade based on Scheme
$scheme = $student['grading_scheme'] ?? 'standard';
$overallGrade = 'F';
$overallRemark = 'Fail';

if ($scheme === 'waec') {
    if ($overallAverage >= 75) { $overallGrade = 'A1'; $overallRemark = 'Excellent'; }
    elseif ($overallAverage >= 70) { $overallGrade = 'B2'; $overallRemark = 'Very Good'; }
    elseif ($overallAverage >= 65) { $overallGrade = 'B3'; $overallRemark = 'Good'; }
    elseif ($overallAverage >= 60) { $overallGrade = 'C4'; $overallRemark = 'Credit'; }
    elseif ($overallAverage >= 55) { $overallGrade = 'C5'; $overallRemark = 'Credit'; }
    elseif ($overallAverage >= 50) { $overallGrade = 'C6'; $overallRemark = 'Credit'; }
    elseif ($overallAverage >= 45) { $overallGrade = 'D7'; $overallRemark = 'Pass'; }
    elseif ($overallAverage >= 40) { $overallGrade = 'E8'; $overallRemark = 'Pass'; }
} else {
    if ($overallAverage >= 70) { $overallGrade = 'A'; $overallRemark = 'Excellent'; }
    elseif ($overallAverage >= 60) { $overallGrade = 'B'; $overallRemark = 'Very Good'; }
    elseif ($overallAverage >= 50) { $overallGrade = 'C'; $overallRemark = 'Good'; }
    elseif ($overallAverage >= 45) { $overallGrade = 'D'; $overallRemark = 'Fair'; }
    elseif ($overallAverage >= 40) { $overallGrade = 'E'; $overallRemark = 'Pass'; }
}

$settings = get_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card - <?= e($student['first_name'] . ' ' . $student['last_name']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Print Specific Styles */
        @media print {
            @page { 
                size: A4 portrait; 
                margin: 0; 
            }
            body { 
                background-color: white !important; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
                padding: 0;
                margin: 0;
            }
            .no-print { display: none !important; }
            .a4-container {
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                box-shadow: none !important;
                border: none !important;
            }
            /* Prevent rows from breaking across pages */
            tr { page-break-inside: avoid; }
        }

        /* Screen specific styles for the A4 paper look */
        @media screen {
            body { background-color: #f1f5f9; padding: 2rem 1rem; }
            .a4-container {
                width: 100%;
                max-width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            }
        }

        /* Custom Colors based on the design */
        .bg-navy { background-color: #0A192F; }
        .text-gold { color: #D4AF37; }
        .bg-gold { background-color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        
        /* Font tweak for premium feel */
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="text-gray-800 antialiased">

    <!-- Print Controls (Hidden on print) -->
    <div class="max-w-[210mm] mx-auto mb-6 no-print flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-200">
        <div>
            <h2 class="font-bold text-gray-800">Report Card Preview</h2>
            <p class="text-xs text-gray-500">This section will not be printed.</p>
        </div>
        <button onclick="window.print()" class="bg-[#0A192F] hover:bg-slate-800 text-white px-6 py-2.5 rounded-lg font-bold shadow-sm flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print / Save as PDF
        </button>
    </div>

    <!-- The A4 Paper -->
    <div class="a4-container bg-white overflow-hidden flex flex-col relative">
        
        <!-- Top Navy Header -->
        <div class="bg-navy px-8 pt-8 pb-6 flex justify-between items-center text-white border-b-4 border-gold">
            <!-- School Logo & Name -->
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center border-2 border-gold p-1">
                    <!-- Replace with actual logo if available -->
                    <div class="w-full h-full bg-navy rounded-full flex items-center justify-center text-gold text-2xl font-bold uppercase">
                        <?= substr($settings['school_name'] ?? 'SD', 0, 2) ?>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold uppercase tracking-widest text-white leading-tight"><?= e($settings['school_name'] ?? 'Summit International School') ?></h1>
                    <p class="text-xs text-gold font-bold uppercase tracking-widest mt-1"><?= e($settings['motto'] ?? 'Nurturing Excellence') ?></p>
                </div>
            </div>

            <!-- Session & Term Box -->
            <div class="border-2 border-gold rounded-lg px-4 py-2 text-center">
                <p class="text-sm font-bold text-white"><?= e($session) ?></p>
                <p class="text-[10px] text-gold uppercase tracking-wider font-bold">Academic Year</p>
            </div>
        </div>

        <!-- Student Info Section -->
        <div class="px-8 py-6 flex justify-between items-end border-b border-gray-200">
            <div class="space-y-2 text-sm">
                <p class="flex gap-2"><span class="text-gray-500 font-semibold w-24">Student Name:</span> <span class="font-bold text-gray-900 uppercase"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></span></p>
                <p class="flex gap-2"><span class="text-gray-500 font-semibold w-24">Grade/Class:</span> <span class="font-bold text-gray-900"><?= e($student['class_name']) ?></span></p>
                <p class="flex gap-2"><span class="text-gray-500 font-semibold w-24">Admission No:</span> <span class="font-bold text-gray-900"><?= e($student['admission_number']) ?></span></p>
                <p class="flex gap-2"><span class="text-gray-500 font-semibold w-24">Term:</span> <span class="font-bold text-gray-900"><?= e($term) ?> (<?= e($session) ?>)</span></p>
            </div>

            <!-- Class Position Badge -->
            <div class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-xl p-3 w-32 shadow-sm">
                <svg class="w-8 h-8 text-gold mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Class Position</p>
                <p class="text-xl font-black text-navy"><?= e($position) ?></p>
            </div>
        </div>

        <!-- Results Table -->
        <div class="px-8 flex-1">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-navy text-white text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 text-left border-r border-slate-700">Subject</th>
                        <th class="py-3 px-2 text-center border-r border-slate-700 w-16">CA<br><span class="text-[9px] text-gray-300">(30%)</span></th>
                        <th class="py-3 px-2 text-center border-r border-slate-700 w-16">Exam<br><span class="text-[9px] text-gray-300">(70%)</span></th>
                        <th class="py-3 px-2 text-center border-r border-slate-700 w-16">Total<br><span class="text-[9px] text-gray-300">(100%)</span></th>
                        <th class="py-3 px-2 text-center border-r border-slate-700 w-16">Grade</th>
                        <th class="py-3 px-4 text-center">Remark</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if(empty($results)): ?>
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-500">
                                No results recorded for this term.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($results as $r): 
                            // Grade color styling
                            $gradeBg = 'bg-white';
                            $gradeText = 'text-gray-800';
                            if (str_starts_with($r['grade'], 'A') || $r['grade'] === 'A') {
                                $gradeBg = 'bg-[#fef3c7]'; // Light Gold/Yellow
                                $gradeText = 'text-[#b45309]';
                            } elseif (str_starts_with($r['grade'], 'B') || $r['grade'] === 'B') {
                                $gradeBg = 'bg-blue-50';
                                $gradeText = 'text-blue-700';
                            } elseif (str_starts_with($r['grade'], 'C') || $r['grade'] === 'C') {
                                $gradeBg = 'bg-green-50';
                                $gradeText = 'text-green-700';
                            } elseif (str_starts_with($r['grade'], 'F')) {
                                $gradeBg = 'bg-red-50';
                                $gradeText = 'text-red-700';
                            }

                            // Calculate remark
                            $score = $r['total_score'];
                            if ($scheme === 'waec') {
                                if ($score >= 75) $remark = 'Excellent';
                                elseif ($score >= 70) $remark = 'Very Good';
                                elseif ($score >= 65) $remark = 'Good';
                                elseif ($score >= 60) $remark = 'Credit';
                                elseif ($score >= 55) $remark = 'Credit';
                                elseif ($score >= 50) $remark = 'Credit';
                                elseif ($score >= 45) $remark = 'Pass';
                                elseif ($score >= 40) $remark = 'Pass';
                                else $remark = 'Fail';
                            } else {
                                if ($score >= 70) $remark = 'Excellent';
                                elseif ($score >= 60) $remark = 'Very Good';
                                elseif ($score >= 50) $remark = 'Good';
                                elseif ($score >= 45) $remark = 'Fair';
                                elseif ($score >= 40) $remark = 'Pass';
                                else $remark = 'Fail';
                            }
                        ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2.5 px-4 font-semibold text-gray-800 border-r border-gray-100"><?= e($r['subject_name']) ?></td>
                                <td class="py-2.5 px-2 text-center text-gray-600 border-r border-gray-100"><?= e($r['ca_score']) ?></td>
                                <td class="py-2.5 px-2 text-center text-gray-600 border-r border-gray-100"><?= e($r['exam_score']) ?></td>
                                <td class="py-2.5 px-2 text-center font-bold text-gray-800 border-r border-gray-100"><?= e($r['total_score']) ?></td>
                                <td class="py-2.5 px-2 text-center border-r border-gray-100">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-bold <?= $gradeBg ?> <?= $gradeText ?>">
                                        <?= e($r['grade']) ?>
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 text-center font-medium text-gray-600"><?= $remark ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Term Summary Row -->
        <div class="px-8 py-4">
            <div class="border border-gray-200 rounded-lg flex divide-x divide-gray-200 text-sm bg-gray-50">
                <div class="flex-1 py-3 px-4 text-center">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Overall Average</p>
                    <p class="font-bold text-navy text-lg"><?= $overallAverageRounded ?>%</p>
                </div>
                <div class="flex-1 py-3 px-4 text-center">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Overall Grade</p>
                    <p class="font-bold text-navy text-lg"><?= $overallGrade ?></p>
                </div>
                <div class="flex-1 py-3 px-4 text-center">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Remark</p>
                    <p class="font-bold text-navy text-lg"><?= $overallRemark ?></p>
                </div>
            </div>
        </div>

        <!-- Signatures & Comments -->
        <div class="px-8 pb-8 pt-4 grid grid-cols-2 gap-12 mt-auto">
            <!-- Class Teacher -->
            <div>
                <div class="h-12 relative flex items-end">
                    <!-- Fake Signature SVG -->
                    <svg class="absolute bottom-0 left-0 w-32 h-12 text-navy opacity-70" viewBox="0 0 100 40" fill="none" stroke="currentColor" stroke-width="2"><path d="M10,30 C20,10 40,20 50,20 C60,20 70,10 80,15 C90,20 95,30 95,30"/></svg>
                </div>
                <div class="border-t border-gray-400 pt-2 flex justify-between text-xs font-semibold text-gray-600">
                    <span>Class Teacher</span>
                    <span>Date: _____________</span>
                </div>
            </div>
            
            <!-- Principal -->
            <div>
                <div class="h-12 relative flex items-end">
                    <!-- Principal's Comment above signature -->
                    <div class="absolute top-0 w-full text-center">
                        <p class="text-[10px] uppercase font-bold text-gray-500 mb-1">Principal's Comment</p>
                        <p class="text-xs text-gray-800 italic">Excellent performance! Keep striving for distinction.</p>
                    </div>
                </div>
                <div class="border-t border-gray-400 pt-2 flex justify-between text-xs font-semibold text-gray-600 mt-4">
                    <span>Principal</span>
                    <span>Date: _____________</span>
                </div>
            </div>
        </div>

        <!-- Footer Quote -->
        <div class="bg-navy py-3 text-center border-t-4 border-gold mt-auto">
            <p class="text-[10px] font-bold text-white uppercase tracking-widest flex items-center justify-center gap-2">
                <span class="text-gold">🌿</span>
                Leaders Today, Change Makers Tomorrow
                <span class="text-gold">🌿</span>
            </p>
        </div>

    </div>

</body>
</html>
