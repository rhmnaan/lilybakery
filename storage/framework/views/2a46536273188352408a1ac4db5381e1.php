<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title>Admin Dashboard - Lily Bakery</title>
    
    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        .lily-pink {
            background-color: #f8b4c4;
        }
        .lily-pink-dark {
            color: #e879a0;
        }
        .lily-pink-bg {
            background-color: #e879a0;
        }
        .text-lily-pink-dark {
            color: #e879a0;
        }
        .bg-lily-pink {
            background-color: #f8b4c4;
        }
        .hover\:bg-lily-pink-dark:hover {
            background-color: #e879a0;
        }
        .border-lily-pink-dark {
            border-color: #e879a0;
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    
    <!-- Scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/layouts/admin.blade.php ENDPATH**/ ?>