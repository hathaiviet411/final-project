<template>
	<div class="atoms-collapse">
		<h6>
			<slot name="label-collapse">
				<span id="collapsed-show-hide" v-b-toggle.toggle-zone-collapse>
					<i class="fas fa-angle-up when-open" />
					<i class="fas fa-angle-down when-closed" />
					<span class="text-collapse">{{ $t('TEXT_COLLAPSE') }}</span>
				</span>
			</slot>
		</h6>

		<div class="zone-collapse">
			<b-collapse id="toggle-zone-collapse" visible>
				<slot name="zone-collapse" />
			</b-collapse>
		</div>
	</div>
</template>

<script>
export default {
    name: 'VCollapse',
};
</script>

<style lang="scss" scoped>
@import '@/scss/variables.scss';

.atoms-collapse {
    h6 {
        width: 100%;
        text-indent: 10%;
        border-bottom: 1px solid $black;
        line-height: 0.1em;
        margin: 10px 0 20px;
        font-size: 16px;

        span {
            background:$white;
            padding: 0 10px;

            i {
                line-height: unset;
            }
        }
        .text-collapse {
            &:hover {
                cursor: pointer;
            }
        }
    }
}

.collapsed > .when-open,
.not-collapsed > .when-closed {
    display: none;
}

.show {
    padding-bottom: 17px;
    border-bottom: 1px solid $black;
}
</style>
