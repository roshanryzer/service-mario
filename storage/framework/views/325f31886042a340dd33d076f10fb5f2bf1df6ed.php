<!-- Main Content -->
<?php $__env->startSection('content'); ?>
<div class="sign-form">
    <div class="columns">
        <div class="column">
            <div class="box b-a-0">
                <div class="p-2 text-xs-center">
                    <h5>Resetar Password</h5>
                </div>
                <form class="form-material mb-1" role="form" method="POST" action="<?php echo e(url('/account/password/email')); ?>" >
                <?php echo e(csrf_field()); ?>

                    <div class="field <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required="true" class="input" id="email" placeholder="Email">
                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="px-2 form-group mb-0">
                        <button type="submit" class="button is-primary is-uppercase">Send Password Reset Link</button>
                    </div>
                </form>
                <div class="p-2 text-xs-center text-muted">
                    <a class="text-black" href="<?php echo e(url('/account/login')); ?>"><span class="underline">Login Here!</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('account.layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>