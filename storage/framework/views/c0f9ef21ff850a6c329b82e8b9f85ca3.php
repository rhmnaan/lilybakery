<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Lily Bakery</title>
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
        .register-bg {
            background: linear-gradient(135deg, #f8b4c4 0%, #e879a0 100%);
        }
    </style>
</head>
<body class="antialiased bg-gray-100 min-h-screen">
    
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Register Section -->
    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                    <p class="text-gray-600">Mohon isi semua data yang diminta untuk menyelesaikan<br>pendaftaran.</p>
                </div>

                <form method="POST" action="">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Name -->
                    <div class="mb-4">
                        <input 
                            type="text" 
                            name="name" 
                            placeholder="Nama :"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                            value="<?php echo e(old('name')); ?>"
                            required
                        >
                        <?php $__errorArgs = ['name'];
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

                    <!-- Email -->
                    <div class="mb-4">
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Email :"
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
                            placeholder="Password :"
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

                    <!-- Phone -->
                    <div class="mb-4">
                        <input 
                            type="tel" 
                            name="phone" 
                            placeholder="Telepon :"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300"
                            value="<?php echo e(old('phone')); ?>"
                            required
                        >
                        <?php $__errorArgs = ['phone'];
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

                    <!-- Address -->
                    <div class="mb-4">
                        <textarea 
                            name="address" 
                            placeholder="Alamat :"
                            rows="3"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:bg-white focus:ring-2 focus:ring-lily-pink-dark focus:outline-none transition duration-300 resize-none"
                            required
                        ><?php echo e(old('address')); ?></textarea>
                        <?php $__errorArgs = ['address'];
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

                    <!-- Gender -->
                    <div class="mb-6">
                        <p class="text-gray-600 mb-3">Jenis Kelamin :</p>
                        <div class="flex space-x-6">
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="gender" 
                                    value="male" 
                                    class="form-radio text-lily-pink-dark focus:ring-lily-pink-dark"
                                    <?php echo e(old('gender') == 'male' ? 'checked' : ''); ?>

                                    required
                                >
                                <span class="ml-2 text-gray-600">Laki-Laki</span>
                            </label>
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="gender" 
                                    value="female" 
                                    class="form-radio text-lily-pink-dark focus:ring-lily-pink-dark"
                                    <?php echo e(old('gender') == 'female' ? 'checked' : ''); ?>

                                    required
                                >
                                <span class="ml-2 text-gray-600">Wanita</span>
                            </label>
                        </div>
                        <?php $__errorArgs = ['gender'];
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

                    <!-- Register Button -->
                    <button 
                        type="submit"
                        class="w-full lily-pink-bg text-white py-3 rounded-full font-medium hover:bg-lily-pink-dark transition duration-300 shadow-md"
                    >
                        Register
                    </button>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Do you have account? 
                        <a href="" class="text-lily-pink-dark hover:underline font-medium">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html><?php /**PATH C:\laragon\www\lilybakery\resources\views/register.blade.php ENDPATH**/ ?>