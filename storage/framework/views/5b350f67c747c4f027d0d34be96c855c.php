<?php $__env->startSection('title', 'Data Benih'); ?>

<?php $__env->startSection('content'); ?>
<div class="board">
    
    <div class="board-header">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;margin-right:8px"><circle cx="12" cy="12" r="10"/><path d="M12 8c0 0-2 2-2 4s2 4 2 4"/><path d="M12 8c0 0 2 2 2 4s-2 4-2 4"/><path d="M8 12h8"/></svg>
            Data Varietas Benih
        </h1>
        <p>Informasi varietas benih Kedelai, Kacang Tanah, dan Kacang Hijau yang tersedia di BRMP Aneka Kacang</p>
    </div>

    
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('benih-list');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3696528565-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('landing.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Downloads\Document\Apps\Seeds\resources\views/landing/benih.blade.php ENDPATH**/ ?>