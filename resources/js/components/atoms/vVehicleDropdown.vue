<template>
	<div class="dropdown-content">
		<b-row lg="1" md="1" sm="1">
			<!-- Vehicle Information -->
			<b-col cols="12">
				<!-- Dropdown Header -->
				<h6>
					<slot name="label-dropdown-content">
						<span id="collapsed-show-hide-dropdown-content" v-b-toggle.dropdown-content>
							<slot>{{ $t('BUTTON.VEHICLE_INFORMATION') }}</slot>
						</span>
					</slot>
				</h6>

				<!-- Dropdown Content -->
				<div class="show-dropdown-content">
					<b-collapse id="dropdown-content" visible>
						<slot name="dropdown-content" />
					</b-collapse>
				</div>
			</b-col>

			<!-- Insurance Information -->
			<b-col cols="12">
				<!-- Dropdown Header -->
				<h6>
					<slot name="label-dropdown-content">
						<span id="collapsed-show-hide-dropdown-content" v-b-toggle.dropdown-content-1>
							<slot>{{ $t('BUTTON.INSURANCE_INFORMATION') }}</slot>
						</span>
					</slot>
				</h6>

				<!-- Dropdown Content -->
				<div class="show-dropdown-content">
					<b-collapse id="dropdown-content-1" visible>
						<slot name="dropdown-content-1" />
					</b-collapse>
				</div>
			</b-col>

			<!-- Remark -->
			<b-col cols="12">
				<!-- Dropdown Header -->
				<h6>
					<slot name="label-dropdown-content">
						<span id="collapsed-show-hide-dropdown-content" v-b-toggle.dropdown-content-2>
							<slot>{{ $t('BUTTON.REMARK') }}</slot>
						</span>
					</slot>
				</h6>

				<!-- Dropdown Content -->
				<div class="show-dropdown-content">
					<b-collapse id="dropdown-content-2" visible>
						<slot name="dropdown-content-2" />
					</b-collapse>
				</div>
			</b-col>
		</b-row>
	</div>
</template>

<script>
export default {
    name: 'VVehicleDropdown',
};
</script>

<style lang="scss" scoped>
    @import '@/scss/variables.scss';

    .dropdown-content {
        margin: 0 auto;
        width: 90%;
        h6 {
            width: 100%;
            text-indent: 5%;
            border-bottom: 1px solid $west-side;
            line-height: 0.1em;
            margin: 10px 0 20px;
            font-size: 16px;
            color: $west-side;
            font-weight: bold;

            span {
                background:$white;
                padding: 0 10px;

                i {
                    line-height: unset;
                }
            }
        }

        .show {
            padding-bottom: 17px;
        }
    }

    .collapsed > .when-open,
    .not-collapsed > .when-closed {
        display: none;
    }
</style>
