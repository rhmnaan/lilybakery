<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Lily Bakery</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .login-bg {
            background: linear-gradient(135deg, #f8b4c4 0%, #e879a0 100%);
        }
    </style>
</head>
<body class="antialiased bg-gray-100 min-h-screen">
    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Login Section -->
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome!</h2>
                    <p class="text-gray-600">Enter your email / mobile number and<br>password to login</p>
                </div>

                <form method="POST" action="">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Email / Mobile Number -->
                    <div class="mb-4">
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Email / Mobile Number"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                            value="<?php echo e(old('email')); ?>"
                            required
                        >
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Your Password"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                            required
                        >
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-left mb-6">
                        <a href="" class="text-gray-600 hover:text-lily-pink-dark text-sm">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full lily-pink-bg text-white py-3 rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                    >
                        Login
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Don't have account? 
                        <a href="<?php echo e(url('/register')); ?>" class="text-lily-pink-dark hover:underline font-medium">Register</a>
                    </p>
                    <p class="text-gray-600 mt-2">
                        Login As Admin? 
                        <a href="<?php echo e(url('/admin-login')); ?>" class="text-lily-pink-dark hover:underline font-medium">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/login.blade.php ENDPATH**/ ?>