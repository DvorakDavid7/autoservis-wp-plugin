<?php
$services = [
    ['id' => 1, 'name' => "Plnění klimatizací"],
    ['id' => 2, 'name' => "Oprava automobilu"],
    ['id' => 3, 'name' => "Příprava na STK"],
    ['id' => 4, 'name' => "Výměna kapalin"],
    ['id' => 5, 'name' => "Přezutí kol"],
    ['id' => 6, 'name' => "Uskladnění kol"],
];

$errors = !empty($_GET['errors']) ? json_decode(stripslashes(urldecode($_GET['errors'])), true) : [];
$old_data = !empty($_GET['data']) ? json_decode(stripslashes(urldecode($_GET['data'])), true) : [];
?>

<form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="submit_reservation">
    <?php wp_nonce_field('reservation_nonce', 'reservation_nonce_field'); ?>

    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900">
                Jméno <span class="text-red-600">*</span>
            </label>
            <input
                id="first-name"
                name="first_name"
                type="text"
                class="border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Jan"
                value="<?= $old_data['first_name'] ?? '' ?>"
                
            />
            <span class="form-error"><?= $errors['first_name'] ?? '' ?></span>
        </div>

        <div>
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900">
                Příjmení <span class="text-red-600">*</span>
            </label>
            <input
                id="last-name"
                name="last_name"
                type="text"
                class="border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Novák"
                value="<?= $old_data['last_name'] ?? '' ?>"
                
            />
            <span class="form-error"><?= $errors['last_name'] ?? '' ?></span>
        </div>

        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                Email <span class="text-red-600">*</span>
            </label>
            <input
                id="email"
                name="email"
                type="email"
                class="border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="jan.novak@seznam.cz"
                value="<?= $old_data['email'] ?? '' ?>"
                
            />
            <span class="form-error"><?= $errors['email'] ?? '' ?></span>
        </div>

        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">
                Telefon <span class="text-red-600">*</span>
            </label>
            <input
                id="phone"
                name="phone"
                type="tel"
                class="border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="722 159 402"
                value="<?= $old_data['phone'] ?? '' ?>"
                
            />
            <span class="form-error"><?= $errors['phone'] ?? '' ?></span>
        </div>

        <div>
            <label for="date" class="block mb-2 text-sm font-medium text-gray-900">
                Datum rezervace <span class="text-red-600">*</span>
            </label>
            <input
                id="datetime-picker"
                name="date"
                type="datetime-local"
                class="border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                value="<?= $old_data['date'] ?? '' ?>"
                
            />
            <span class="form-error"><?= $errors['date'] ?? '' ?></span>
        </div>

        <div>
            <label for="services" class="block mb-2 text-sm font-medium text-gray-900">
                Vyberte službu <span class="text-red-600">*</span>
            </label>
            <select name="service" id="services"  class="border border-gray-300 bg-white text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="" disabled selected>Vyberte službu</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= esc_attr($service['name']) ?>"><?= esc_html($service['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form-error"><?= $errors['service'] ?? '' ?></span>
        </div>
    </div>

    <div>
        <label for="message" class="block mb-2 text-sm font-medium text-gray-900">
            Poznámka k rezervaci
        </label>
        <textarea
            id="message"
            name="message"
            rows="4"
            class="block p-2.5 w-full text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Váš text..."
            value="<?= $old_data['message'] ?? '' ?>"
        ></textarea>
    </div>

    <div class="mt-3">
        <input  id="default-checkbox" type="checkbox" name="privacy_policy"
               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
        <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-500">
            Souhlasím se zpracováním osobních údajů podle
            <a href="/zasady-ochrany-osobnich-udaju" class="underline">zásad ochrany osobních údajů</a>.
        </label>
        <span class="form-error"><?= $errors['privacy_policy'] ?? '' ?></span>
    </div>

    <div class="flex mt-10 mb-10 justify-end">
        <button
            type="submit"
            class="flex justify-center items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-4 text-center"
        >
            <strong>REZERVOVAT</strong>
        </button>
    </div>
</form>
