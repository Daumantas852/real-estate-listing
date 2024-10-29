<?php
// Render House Meta Box
function render_house_meta_box($post) {
    $fields = array(
        'price' => 'Price',
        'address' => 'Address',
        'house_type' => 'House Type',
        'land_area' => 'Land Area',
        'room_count' => 'Room Count',
        'floor_count' => 'Floor Count',
        'year_built' => 'Year Built',
        'furnishing' => 'Furnishing',
        'energy_efficiency' => 'Energy Efficiency',
    );

    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo "<p><label for='{$key}'>{$label}</label>";
        echo "<input type='text' name='{$key}' id='{$key}' value='" . esc_attr($value) . "' class='widefat' /></p>";
    }

    echo "<style>#price { color: red; }</style>";
}

// Render Floor Meta Box for Dynamic Floors with Multiple Images
function render_floor_meta_box($post) {
    $floors = get_post_meta($post->ID, 'floors', true);
    $floors = !empty($floors) ? $floors : [];

    echo '<div id="floor-container">';
    foreach ($floors as $index => $floor) {
        echo "<div class='floor-item' data-index='{$index}'>
                <p><label>Floor Name</label><input type='text' name='floors[{$index}][name]' value='" . esc_attr($floor['name']) . "' class='widefat' /></p>
                <div class='floor-images' id='floor-images-{$index}'>";

        // Add the six default room names
        $roomNames = ['Miegamasis', 'Antras miegamasis', 'Vonia', 'Virtuve', 'Tuoletas', 'Koridorius'];
        foreach ($roomNames as $roomIndex => $roomName) {
            $image_url = isset($floor['images'][$roomIndex]) ? esc_url($floor['images'][$roomIndex]) : '';
            $img_display = !empty($image_url) ? 'block' : 'none';
            echo "<div class='floor-image-item'>
                    <p>{$roomName}</p>
                    <input type='hidden' name='floors[{$index}][images][{$roomIndex}]' value='{$image_url}' class='image-url'/>
                    <img src='{$image_url}' style='width: 100px; height: auto; margin-right: 5px; display: {$img_display};' class='preview-image'/>
                    <button type='button' class='button select-images' data-index='{$index}' data-room-index='{$roomIndex}'>Select Image</button>
                 </div>";
        }

        echo "</div></div>";
    }
    echo '</div>';
    echo '<button type="button" id="add-floor-button" class="button">Add Floor</button>';
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('floor-container');
            const button = document.getElementById('add-floor-button');

            button.addEventListener('click', function () {
                const index = container.children.length;
                const roomNames = ['Miegamasis', 'Antras miegamasis', 'Vonia', 'Virtuve', 'Tuoletas', 'Koridorius'];
                let html = `<div class='floor-item' data-index='${index}'>
                                <p><label>Floor Name</label><input type='text' name='floors[${index}][name]' value='Floor ${index + 1}' class='widefat' /></p>
                                <div class='floor-images' id='floor-images-${index}'>`;

                // Add the six default room names with image upload buttons
                roomNames.forEach((roomName, i) => {
                    html += `<div class='floor-image-item'>
                                <p>${roomName}</p>
                                <input type='hidden' name='floors[${index}][images][${i}]' value='' class='image-url'/>
                                <img src='' style='width: 100px; height: auto; margin-right: 5px; display:none;' class='preview-image'/>
                                <button type='button' class='button select-images' data-index='${index}' data-room-index='${i}'>Select Image</button>
                             </div>`;
                });

                html += `</div></div>`;
                container.insertAdjacentHTML('beforeend', html);
            });

            // Handle Image Selection
            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('select-images')) {
                    e.preventDefault();
                    const index = e.target.getAttribute('data-index');
                    const roomIndex = e.target.getAttribute('data-room-index');
                    const frame = wp.media({
                        title: 'Select or Upload Room Image',
                        button: {
                            text: 'Use this image'
                        },
                        multiple: false
                    });

                    frame.on('select', function () {
                        const selection = frame.state().get('selection').first();
                        const imageUrl = selection.attributes.url;
                        const imageInput = document.querySelector(`input[name='floors[${index}][images][${roomIndex}]']`);
                        const imagePreview = imageInput.nextElementSibling;

                        imageInput.value = imageUrl;
                        imagePreview.src = imageUrl;
                        imagePreview.style.display = 'block';
                    });

                    frame.open();
                }
            });
        });
    </script>
    <?php
}
?>
