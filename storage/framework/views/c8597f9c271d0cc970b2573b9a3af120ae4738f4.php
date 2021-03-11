<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="columns">
        <div class="column">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form  role="form" method="POST" action="<?php echo e(url('/account/register')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="field<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="column control-label">Name</label>

                            <div class="column">
                                <input id="name" type="text" class="input" name="name" value="<?php echo e(old('name')); ?>" autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="field<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="column control-label">E-Mail Address</label>

                            <div class="column">
                                <input id="email" type="email" class="input" name="email" value="<?php echo e(old('email')); ?>">

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="field<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="column control-label">Password</label>

                            <div class="column">
                                <input id="password" type="password" class="input" name="password">

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="field<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                            <label for="password-confirm" class="column control-label">Confirm Password</label>

                            <div class="column">
                                <input id="password-confirm" type="password" class="input" name="password_confirmation">

                                <?php if($errors->has('password_confirmation')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="column">
                                <button type="submit" class="button is-link">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('account.layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>