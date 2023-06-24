<?php
/*
Plugin Name: Real Estate Plugin
Description: Плагін для ініціалізації типу запису "Об'єкт нерухомості" і таксономії "Район".
Version: 1.0
Author: yucky
*/

function register_real_estate_post_type() {
    $labels = array(
        'name'               => 'Об\'єкти нерухомості',
        'singular_name'      => 'Об\'єкт нерухомості',
        'add_new'            => 'Додати новий',
        'add_new_item'       => 'Додати новий об\'єкт нерухомості',
        'edit_item'          => 'Редагувати об\'єкт нерухомості',
        'new_item'           => 'Новий об\'єкт нерухомості',
        'view_item'          => 'Переглянути об\'єкт нерухомості',
        'search_items'       => 'Шукати об\'єкти нерухомості',
        'not_found'          => 'Об\'єкти нерухомості не знайдені',
        'not_found_in_trash' => 'Об\'єкти нерухомості не знайдені в кошику',
        'parent_item_colon'  => 'Батьківський об\'єкт нерухомості:',
        'menu_name'          => 'Об\'єкти нерухомості'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-building',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor' ),
        'has_archive'         => true,
        'rewrite'             => array( 'slug' => 'real-estate' ),
        'query_var'           => true
    );

    register_post_type( 'real_estate', $args );
}
add_action( 'init', 'register_real_estate_post_type' );

function register_district_taxonomy() {
    $labels = array(
        'name'                       => 'Райони',
        'singular_name'              => 'Район',
        'search_items'               => 'Шукати райони',
        'popular_items'              => 'Популярні райони',
        'all_items'                  => 'Всі райони',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Редагувати район',
        'update_item'                => 'Оновити район',
        'add_new_item'               => 'Додати новий район',
        'new_item_name'              => 'Назва нового району',
        'separate_items_with_commas' => 'Розділіть райони комами',
        'add_or_remove_items'        => 'Додати або видалити райони',
        'choose_from_most_used'      => 'Обрати з найпопулярніших районів',
        'not_found'                  => 'Райони не знайдені',
        'menu_name'                  => 'Райони',
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'district' ),
        'multiple'              => false, // Запрещает выбор нескольких значений
    );

    register_taxonomy( 'district', 'real_estate', $args );
}
add_action( 'init', 'register_district_taxonomy' );

function real_estate_search_results() {
    $search_params = $_POST['search_params'];
    $page = isset($search_params['page']) ? intval($search_params['page']) : 1;
    $posts_per_page = 10;
    $offset = ($page - 1) * $posts_per_page;

    $search_results = array();

    $args = array(
        'post_type' => 'real_estate',
        'tax_query' => array(),
        'meta_query' => array(),
        'posts_per_page' => $posts_per_page,
        'offset'         => $offset,
        'paged'          => $page
    );

    if (!empty($search_params['district'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'district',
            'field' => 'name',
            'terms' => $search_params['district'],
        );
    }
    if (!empty(intval($search_params['house_floors']))) {
        $args['meta_query'][] = array(
            'key' => 'floors',
            'value' => intval($search_params['house_floors']),
            'compare' => 'LIKE',
        );
    }
    if (!empty($search_params['house_coordinates'])) {
        $args['meta_query'][] = array(
            'key' => 'location_coordinates',
            'value' => $search_params['house_coordinates'],
            'compare' => 'LIKE',
        );
    }

    if (!empty($search_params['house_type'])) {
        $args['meta_query'][] = array(
            'key' => 'building_type',
            'value' => $search_params['house_type'],
            'compare' => 'LIKE',
        );
    }

    if (!empty($search_params['house_name'])) {
        $args['meta_query'][] = array(
            'key' => 'house_name',
            'value' => $search_params['house_name'],
            'compare' => 'LIKE',
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $field_value_1 = get_field('district');
            $field_value_2 = get_field('location_coordinates');
            $field_value_3 = get_field('building_type');
            $field_value_4 = get_field('house_name');
            $field_value_5 = get_field('floors');

            $result = array(
                'field_name_1' => $field_value_1,
                'field_name_2' => $field_value_2,
                'field_name_3' => $field_value_3,
                'field_name_4' => $field_value_4,
                'field_name_5' => $field_value_5,
            );

            $search_results[] = $result;
        }
        wp_reset_postdata();
    }

    if (!empty($search_results)) {
        $output = '';
        foreach ($search_results as $result) {
            if (!empty($result['field_name_1'])){
                $output .= '<p>' .'<h5>'.'Район :'.'</h5>'. $result['field_name_1'] . '</p>';
            }
            if (!empty($result['field_name_2'])){
                $output .= '<p>' .'<h5>'.'Координати :'.'</h5>'. $result['field_name_2'] . '</p>';
            }
            if (!empty($result['field_name_3'])){
                $output .= '<p>' .'<h5>'.'Тип будівлі :'.'</h5>'. $result['field_name_3'] .'</p>';
            }
            if (!empty($result['field_name_4'])){
                $output .= '<p>' .'<h5>'.'Назва будинку :'.'</h5>'. $result['field_name_4'] .'</p>';
            }
            if (!empty($result['field_name_5'])){
                $output .= '<p>' .'<h5>'.'Кількість поверхів :'.'</h5>'. $result['field_name_5'] .'</p>';
            }



            $output .= '<br>';
            $output .= '<hr>';
        }
        $output .= '<button id="nextpages" value="'.$search_params['page']+1 .'">Наступна сторінка</button>';
        $output .= '<div style="display: none"id="pages">'.$search_params['page'].'</div>';
        echo $output;
    } else {
        echo 'Результаты не найдены.';
    }

    wp_die();
}

add_action('wp_ajax_real_estate_search', 'real_estate_search_results');
add_action('wp_ajax_nopriv_real_estate_search', 'real_estate_search_results');



function add_real_estate_fields() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( array(
            'key'       => 'group_1',
            'title'     => 'Поля об\'єкта нерухомості',
            'fields'    => array(
                array(
                    'key'           => 'field_1',
                    'label'         => 'Назва дому',
                    'name'          => 'house_name',
                    'type'          => 'text',
                    'required'      => true,
                ),
                array(
                    'key'           => 'field_2',
                    'label'         => 'Координати місцезнаходження',
                    'name'          => 'location_coordinates',
                    'type'          => 'text',
                    'required'      => true,
                ),
                array(
                    'key'           => 'field_3',
                    'label'         => 'Кількість поверхів',
                    'name'          => 'floors',
                    'type'          => 'number',
                    'required'      => true,
                    'min'           => 1,
                    'max'           => 20,
                ),
                array(
                    'key'           => 'field_4',
                    'label'         => 'Тип будівлі',
                    'name'          => 'building_type',
                    'type'          => 'radio',
                    'choices'       => array(
                        'panel'    => 'Панель',
                        'brick'    => 'Кирпич',
                        'foam'     => 'Пеноблок',
                    ),
                    'required'      => true,
                ),
            ),
            'location'  => array(
                array(
                    array(
                        'param'     => 'post_type',
                        'operator'  => '==',
                        'value'     => 'real_estate',
                    ),
                ),
            ),
        ) );
    }
}
add_action( 'acf/init', 'add_real_estate_fields' );

function display_real_estate_data() {
    if ( is_singular( 'real_estate' ) ) {
        $house_name = get_field( 'house_name' );
        $location_coordinates = get_field( 'location_coordinates' );
        $floors = get_field( 'floors' );
        $building_type = get_field( 'building_type' );

        echo '<h2>' . $house_name . '</h2>';
        echo '<p>Координати: ' . $location_coordinates . '</p>';
        echo '<p>Кількість поверхів: ' . $floors . '</p>';
        echo '<p>Тип будівлі: ' . $building_type . '</p>';
    }
}
add_action( 'wp', 'display_real_estate_data' );

function real_estate_filter_shortcode() {
    ob_start();
    ?>
    <div class="real-estate-filter-widget">
        <h3 class="widget-title">Фільтр об'єктів нерухомості</h3>
        <form id="real-estate-search-form">
            <label for="district-input">Район:</label><br>
            <input type="text" id="district-input" name="district">
            <br>
            <label for="house-name-input">Назва будинку:</label><br>
            <input type="text" id="house-name-input" name="house_name">
            <br>
            <label for="house-coordinates-input">Координати:</label><br>
            <input type="text" id="house-coordinates-input" name="house_coordinates">
            <br>
            <label for="house-floors-input">Кількість поверхів:</label><br>
            <input type="number" id="house-floors-input" name="house_floors">
            <br>
            <label for="house-type-input">Тип будівлі:</label><br>
            <label for="house-type-input" style="font-size: 10px;">Панель</label><br>
            <input type="radio" id="house-type-input" value="panel" name="house-type"><br>
            <label for="house-type-input-1" style="font-size: 10px;">Цегла</label><br>
            <input type="radio"  id="house-type-input-1" value="brick" name="house-type"><br>
            <label for="house-type-input-2" style="font-size: 10px;">Пеноблок</label><br>
            <input type="radio" id="house-type-input-2" value="foam" name="house-type">
            <br>
            <button type="button" id="real-estate-search-button">Пошук</button>
        </form>
        <div id="search-results"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'real_estate_filter', 'real_estate_filter_shortcode' );

class Real_Estate_Filter_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'real_estate_filter_widget',
            'Real Estate Filter Widget',
            array( 'description' => 'Віджет блока фільтра по об\'єктах нерухомості' )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        ?>
        <div class="real-estate-filter-widget">
            <h3 class="widget-title">Фільтр об'єктів нерухомості</h3>
            <div id="widget-body"></div>
        </div>
        <?php
        echo $args['after_widget'];
    }
}

function register_real_estate_filter_widget() {
    register_widget( 'Real_Estate_Filter_Widget' );
}

add_action( 'widgets_init', 'register_real_estate_filter_widget' );

function enqueue_scripts() {

    wp_enqueue_script( 'real-estate-ajax', plugins_url() . '/real-estate-plugin/real-estate-ajax.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'real-estate-ajax', 'realEstateAjax', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );


