<?php
function generate_text()
{
    global $wpdb;

    $term = sanitize_text_field($_POST['term']);
    $original_term = ucfirst(mb_strtolower($term));

    // запит до бази даних для отримання терміна
    $result = $wpdb->get_row($wpdb->prepare("SELECT term, definition, category, subcategory FROM glossary WHERE term LIKE %s", '%'.$wpdb->esc_like($term).'%'));
    
    if (!$result)       // якщо введенего терміна не знайдено, спробуємо знайти найближчий термін (levenshtein)
    {
        // отримуємо всі терміни для подальшого аналізу
        $terms = $wpdb->get_col("SELECT term FROM glossary");
        $closest_term = null;
        $closest_distance = PHP_INT_MAX;
        
        foreach ($terms as $db_term)
        {
            $distance = levenshtein(mb_strtolower($term), mb_strtolower($db_term));
            
            if ($distance < $closest_distance)
            {
                $closest_distance = $distance;
                $closest_term = $db_term;
            }
        }
        
        if ($closest_term)      // якщо знайдено найближчий термін
        {
            $result = $wpdb->get_row($wpdb->prepare("SELECT term, definition, category, subcategory FROM glossary WHERE term = %s", $closest_term));
        }
    }

    if ($result)
    {
        $term = ucfirst(mb_strtolower($term));
        $closest_term = $closest_term ? ucfirst(mb_strtolower($closest_term)) : $original_term;
        $definition = mb_strtolower(mb_substr($result->definition, 0, 1)).mb_substr($result->definition, 1);
        $category = $result->category ? 'відноситься до категорії – '.ucfirst(mb_strtolower($result->category)) : 'не має категорії';
        $subcategory = $result->subcategory ? 'відноситься до  підкатегорії – '.ucfirst(mb_strtolower($result->subcategory)) : 'не має підкатегорії';

        $response = sprintf(
            'Ви ввели: <strong>%s</strong><br><br>%s – це %s.<br>● Цей термін %s.<br>● Цей термін %s.',
            esc_html($term),
            esc_html($closest_term),
            esc_html($definition),
            esc_html($category),
            esc_html($subcategory)
        );

        //  формуємо відповідь довжиною до 500 символів
        if (mb_strlen($response) > 500)
        {
            $response = mb_substr($response, 0, 500) . '...';
        }

        wp_send_json_success($response);
    }
    else
    {
        wp_send_json_success('Не вдалося знайти термін. Спробуйте ввести правильний термін!');
    }

    wp_die();
}

// виконується дія для авторизованих користувачів
add_action('wp_ajax_generate_text', 'generate_text');
// виконується дія для НЕавторизованих користувачів
add_action('wp_ajax_nopriv_generate_text', 'generate_text');