<?php
// resources/views/components/timetable_grid.php
// Expects: $slots (array of timetable slots)
?>

<div class="space-y-6">
    <?php 
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    foreach($days as $day): 
        // Filter slots for this specific day
        $daySlots = array_filter($slots, function($slot) use ($day) {
            return $slot['day_of_week'] === $day;
        });
    ?>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 uppercase tracking-wider"><?= $day ?></h3>
                <span class="text-xs bg-primary text-white px-2 py-1 rounded-full font-bold"><?= count($daySlots) ?> Classes</span>
            </div>
            
            <?php if(empty($daySlots)): ?>
                <div class="p-6 text-center text-gray-400 text-sm">No classes scheduled.</div>
            <?php else: ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach($daySlots as $slot): ?>
                        <div class="p-4 sm:px-6 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-24 text-sm font-bold text-gray-500 shrink-0">
                                    <?= date('g:i A', strtotime($slot['start_time'])) ?> <br>
                                    <?= date('g:i A', strtotime($slot['end_time'])) ?>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900"><?= e($slot['subject_name']) ?></p>
                                    <p class="text-xs text-gray-500">
                                        <?= $slot['teacher_fname'] ? e($slot['teacher_fname'] . ' ' . $slot['teacher_lname']) : 'No Teacher Assigned' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
