<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card - <?= e($student['first_name']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; -webkit-print-color-adjust: exact; }
            .page-break { page-break-after: always; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 font-sans text-gray-900">

    <!-- Print Controls (Hidden on paper) -->
    <div class="max-w-4xl mx-auto mb-6 no-print flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
        <div>
            <h2 class="font-bold text-gray-700">Print Preview</h2>
            <p class="text-xs text-gray-500">This section will not be printed.</p>
        </div>
        <button onclick="window.print()" class="bg-primary hover:bg-blue-900 text-white px-6 py-2 rounded-lg font-medium shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Report Card
        </button>
    </div>

    <!-- Actual Report Card -->
    <div class="max-w-4xl mx-auto bg-white p-10 shadow-lg border border-gray-200" style="min-height: 1000px;">
        
        <?php $settings = get_settings(); ?>
        <!-- School Header -->
        <div class="text-center border-b-2 border-gray-800 pb-6 mb-6">
            <div class="flex justify-center items-center gap-4 mb-2">
                <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center font-bold text-2xl uppercase">
                    <?= substr($settings['school_name'] ?? 'SD', 0, 2) ?>
                </div>
                <div class="text-left">
                    <h1 class="text-3xl font-extrabold uppercase tracking-widest text-gray-900"><?= e($settings['school_name'] ?? 'WebVault SchoolDesk') ?></h1>
                    <p class="text-sm text-gray-600 font-medium"><?= e($settings['address'] ?? '123 Education Way') ?> | <?= e($settings['phone'] ?? '') ?></p>
                    <p class="text-xs text-gray-500 italic mt-1">Motto: <?= e($settings['motto'] ?? 'Knowledge is Power') ?></p>
                </div>
            </div>
            <h2 class="text-xl font-bold bg-gray-100 py-2 rounded uppercase tracking-wide mt-4">Terminal Report Sheet</h2>
        </div>

        <!-- Student Info -->
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div class="space-y-1">
                <p><span class="font-bold text-gray-600">Student Name:</span> <span class="uppercase font-bold text-gray-900"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></span></p>
                <p><span class="font-bold text-gray-600">Admission No:</span> <?= e($student['admission_number']) ?></p>
                <p><span class="font-bold text-gray-600">Class:</span> <?= e($student['class_name']) ?></p>
            </div>
            <div class="space-y-1 text-right">
                <p><span class="font-bold text-gray-600">Session:</span> <?= e($session) ?></p>
                <p><span class="font-bold text-gray-600">Term:</span> <?= e($term) ?></p>
                <p><span class="font-bold text-gray-600">Gender:</span> <?= e($student['gender']) ?></p>
            </div>
        </div>

        <!-- Results Table -->
        <table class="w-full border-collapse border border-gray-300 mb-6 text-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="border border-gray-300 px-4 py-2 text-left">Subject</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">CA (30)</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Exam (70)</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Total (100)</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Grade</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($results)): ?>
                    <tr>
                        <td colspan="6" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                            No results recorded for this term.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($results as $r): 
                        // Recalculate the correct remark based on the class scheme
                        $scheme = $student['grading_scheme'] ?? 'standard';
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
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 font-medium"><?= e($r['subject_name']) ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= e($r['ca_score']) ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= e($r['exam_score']) ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-bold"><?= e($r['total_score']) ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-bold <?= str_contains($r['grade'], 'F') ? 'text-red-600' : 'text-green-600' ?>"><?= e($r['grade']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $remark ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Summary Section -->
        <div class="grid grid-cols-3 gap-4 mb-10 border-t-2 border-gray-200 pt-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Aggregate</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-1"><?= e($totalAggregate) ?></p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Subjects Offered</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-1"><?= e($totalSubjects) ?></p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Class Position</p>
                <p class="text-2xl font-extrabold text-primary mt-1"><?= e($position) ?></p>
            </div>
        </div>

        <!-- Comments -->
        <div class="space-y-6 mt-12">
            <div>
                <p class="text-sm font-bold text-gray-700 mb-1">Class Teacher's Remark:</p>
                <div class="border-b-2 border-dotted border-gray-400 pb-2 h-8"></div>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-700 mb-1">Principal's Remark:</p>
                <div class="border-b-2 border-dotted border-gray-400 pb-2 h-8"></div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-16 text-center text-xs text-gray-400">
            <p>Generated by WebVault SchoolDesk on <?= date('F j, Y') ?></p>
        </div>
    </div>

</body>
</html>
