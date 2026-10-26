<?php

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( $hook !== 'appearance_page_ttb-rotator' ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script(
		'ttb-rotator-admin',
		get_theme_file_uri( 'scripts/image-rotator-admin.js' ),
		[ 'media-editor' ],
		wp_get_theme()->get( 'Version' ),
		true
	);
} );

// 1. Option + sanitizing
add_action( 'admin_init', function () {
	register_setting( 'ttb_settings', 'ttb_rotator_images', [
		'type'              => 'array',
		'default'           => [],
		'sanitize_callback' => function ( $value ) {
			$ids = is_array( $value ) ? $value : explode( ',', (string) $value );
			return array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
		},
	] );
} );

// 2. Menu page: Appearance → Image Rotator
add_action( 'admin_menu', function () {
	add_theme_page(
		'Image Rotation on Home Page',
		'Image Rotation',
		'edit_theme_options',
		'ttb-rotator',
		'ttb_render_settings_page'
	);
} );

// 3. Page markup (the JS lives in scripts/image-rotator-admin.js)
function ttb_render_settings_page() {
	$ids = (array) get_option( 'ttb_rotator_images', [] );
	?>
	<div class="wrap">
		<span class="dashicons dashicons-editor-help"
		      title="Use drag and drop to reorder"
		      aria-label="Use drag and drop to reorder"
		      role="img"
		      style="float:right;display:inline-block;vertical-align:middle;cursor:help;">
		</span>
		<h1>Image Rotation on Home Page</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'ttb_settings' ); ?>
			<input type="hidden" id="ttb-ids" name="ttb_rotator_images" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>">

			<ul id="ttb-list" style="display:flex;flex-wrap:wrap;gap:8px;margin:1em 0;padding:0;list-style:none">
				<?php foreach ( $ids as $id ) : ?>
					<li data-id="<?php echo (int) $id; ?>" style="position:relative;cursor:move">
						<?php
						echo wp_get_attachment_image( $id, [ 100, 100 ], false, [
							'style' => 'display:block;object-fit:cover;width:100px;height:100px',
						] );
						?>
						<button type="button" class="ttb-remove" style="position:absolute;top:2px;right:2px" aria-label="Remove">&times;</button>
					</li>
				<?php endforeach; ?>
			</ul>

			<p><button type="button" class="button" id="ttb-select">Select images</button></p>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

add_action( 'wp_dashboard_setup', function() {
    wp_add_dashboard_widget(
      'ttb_welcome_widget', // widget_id
      'The Textile Buffet', // widget_name = title
      'ttb_render_dashboard_widget' // callback
    );}
);

function ttb_render_dashboard_widget() {
  echo<<<EOT
<style>
  #ttb_welcome_widget {
    background-color:#f0efb6;
    color:#000000;
  }
  #ttb_welcome_widget ul li a {
      font-size: 2rem;
  }
</style>
<div>
  <ul>
    <li>
      <a href="/wp-admin/edit.php?post_type=tribe_events">Edit Events</a>
    </li>
        <li>
      <a href="/wp-admin/edit.php?post_type=page">Edit Pages</a>
    </li>
        <li>
      <a href="/wp-admin/themes.php?page=ttb-rotator">Edit Image Rotation on Home Page</a>
    </li>
  </ul>
</div>
EOT;
}