<div class="exception">
	<div class="exception_title">An Exception Of Type <?php echo get_class($this->Exception)?> Has Been Caught!</div>
	<div class="exception_info">
		<div class="exception_message"> <?php echo $this->Exception->getMessage()?></div>
		<div class="exception_stack">
			<strong>Stack Trace:</strong>
			<ol>
				<?php
				 
				foreach($this->Traces as $trace)
				{
					?>
					<li>
						<?php echo $trace ?>
					</li>
					<?php
				}
				?>
			</ol>
		</div>
	</div>
</div>