<div class="wrap">
	<h2><?php echo $this->plugin->displayName; ?> &raquo; <?php esc_html_e( 'Settings', 'ihafplugin' ); ?></h2>

	<?php
	if ( isset( $this->message ) ) {
		?>
		<div class="updated fade"><p><?php echo $this->message; ?></p></div>
		<?php
	}
	if ( isset( $this->errorMessage ) ) {
		?>
		<div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>
		<?php
	}
	?>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<!-- Content -->
			<div id="post-body-content">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<h3 class="hndle"><?php esc_html_e( 'Settings', 'ihafplugin' ); ?></h3>

						<div class="inside">
							<form action="options-general.php?page=<?php echo $this->plugin->name; ?>" method="post">
								<p>
									<label for="ihaf_insert_header_plugin"><strong><?php esc_html_e( 'Scripts in Header', 'ihafplugin' ); ?></strong></label>
									<textarea name="ihaf_insert_header_plugin" id="ihaf_insert_header_plugin" class="widefat" rows="8" style="font-family:Courier New;" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?>><?php echo $this->settings['ihaf_insert_header_plugin']; ?></textarea>
									<?php
									printf(
										/* translators: %s: The `<head>` tag */
										esc_html__( 'These scripts will be printed in the %s section.', 'ihafplugin' ),
										'<code>&lt;head&gt;</code>'
									);
									?>
								</p>
								<?php if ( $this->body_open_supported ) : ?>
								<p>
									<label for="ihaf_insert_body_plugin"><strong><?php esc_html_e( 'Scripts in Body', 'ihafplugin' ); ?></strong></label>
									<textarea name="ihaf_insert_body_plugin" id="ihaf_insert_body_plugin" class="widefat" rows="8" style="font-family:Courier New;" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?>><?php echo $this->settings['ihaf_insert_body_plugin']; ?></textarea>
									<?php
									printf(
										/* translators: %s: The `<head>` tag */
										esc_html__( 'These scripts will be printed just below the opening %s tag.', 'ihafplugin' ),
										'<code>&lt;body&gt;</code>'
									);
									?>
								</p>
								<?php endif; ?>
								<p>
									<label for="ihaf_insert_footer_plugin"><strong><?php esc_html_e( 'Scripts in Footer', 'ihafplugin' ); ?></strong></label>
									<textarea name="ihaf_insert_footer_plugin" id="ihaf_insert_footer_plugin" class="widefat" rows="8" style="font-family:Courier New;" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?>><?php echo $this->settings['ihaf_insert_footer_plugin']; ?></textarea>
									<?php
									printf(
										/* translators: %s: The `</body>` tag */
										esc_html__( 'These scripts will be printed above the closing %s tag.', 'ihafplugin' ),
										'<code>&lt;/body&gt;</code>'
									);
									?>
								</p>
								<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>
									<?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>
									<p>
										<input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php esc_attr_e( 'Save', 'ihafplugin' ); ?>" />
									</p>
								<?php endif; ?>
							</form>
						</div>
					</div>
					<!-- /postbox -->
				</div>
				<!-- /normal-sortables -->
			</div>
			<!-- /post-body-content -->

			<!-- Sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				<?php require_once( $this->plugin->folder . '/views/sidebar.php' ); ?>
			</div>
			<!-- /postbox-container -->
		</div>
	</div>
</div>
