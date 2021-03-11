<?php $__env->startSection('content'); ?>

<?php $login_user = asset('asset/img/login-user-bg.jpg'); ?>
<div class="full-page-bg" style="background-image: url(<?php echo e($login_user); ?>);">
<div class="log-overlay"></div>
    <div class="full-page-bg-inner">
        <div class="columns no-margin">
            <div class="column log-left">
                <span class="login-logo"><img src="<?php echo e(config('constants.site_logo', asset('logo-black.png'))); ?>"></span>
                <h2>Crie sua conta e mova-se em minutos</h2>
                <p>Bem-vindo(a) ao <?php echo e(config('constants.site_title', 'Moob Urban')); ?>, a maneira mais fácil de se locomover com o toque de um botão.</p>
            </div>
            <div class="column log-right">
                <div class="login-box-outer">
                <div class="login-box columns no-margin">
                    <div class="column">
                        <a class="log-blk-btn" href="<?php echo e(url('login')); ?>">JÁ TEM UMA CONTA?</a>
                        <h3>Redefinir Password</h3>
                    </div>
                     <?php if(session('status')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                    <form role="form" method="POST" action="<?php echo e(url('/password/reset')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="token" value="<?php echo e($token); ?>">

                        <div class="column">
                            <input type="email" class="input" name="email" placeholder="Seu e-mail" value="<?php echo e(old('email')); ?>">

                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                </span>
                            <?php endif; ?>                        
                        </div>
                        <div class="column">
                            <input type="password" class="input" name="password" placeholder="Password">

                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="column">
                            <input type="password" placeholder="Repita a Password" class="input" name="password_confirmation">

                            <?php if($errors->has('password_confirmation')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="column">
                            <button class="log-teal-btn" type="submit">REDEFINIR Password</button>
                        </div>
                    </form>     

                    <div class="column">
                        <p class="helper">Ou <a href="<?php echo e(route('login')); ?>">Entre</a> com sua conta de usuário.</p>   
                    </div>

                </div>


                <div class="log-copy"><p class="no-margin"><?php echo e(config('constants.site_copyright', '&copy; '.date('Y').' Service Mario')); ?></p></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>