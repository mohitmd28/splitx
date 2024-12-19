<div class="mb-4.5">
    <div>
        <label class="mb-2.5 block text-black dark:text-white">
            Name <span class="text-meta-1">*</span>
        </label>

        <input type="text" name="name" placeholder="Enter name" value="<?= old('name', $event ? $event->name : '') ?>" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />

        <?php if (error('name')) : ?>
            <span class="danger" style="color: red;">
                <?= error('name') ?>
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="mb-4.5">
    <label class="mb-2.5 block text-black dark:text-white">
        Select Group
    </label>
    <div class="relative z-20 bg-transparent dark:bg-form-input">
        <select name="group_id" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
            <?php foreach ($groups as $group) :  ?>
                <option value="<?= $group->id ?>" <?= old('group_id', $event ? $event->group_id : '') === $group->id ? 'selected' : '' ?>>
                    <?= $group->name ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.8">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill=""></path>
                </g>
            </svg>
        </span>

        <?php if (error('group_id')) : ?>
            <span class="danger" style="color: red;">
                <?= error('group_id') ?>
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="mb-4.5">
    <label class="mb-2.5 block text-black dark:text-white">
        Event Date <span class="text-meta-1">*</span>
    </label>
    <div class="relative">
        <?php
        $date = old('date', $event ? $event->date : date_format(new DateTime(), "Y-m-d"));
        ?>
        <input type="date" name="date" value="<?= date_format(new DateTime($date), "Y-m-d") ?>" class="custom-input-date custom-input-date-1 w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />

        <?php if (error('date')) : ?>
            <span class="danger" style="color: red;">
                <?= error('date') ?>
            </span>
        <?php endif; ?>
    </div>
</div>

<?php if (($message = session()->get('success'))) : ?>
    <div class="p-2 text-primary"><?= $message ?></div>
<?php endif; ?>