<template>
	<div class="header-collapse">
		<p>
			<slot name="label-collapse">
				<span id="collapsed-show-hide-collapse" v-b-toggle.zone-collapse>
					<i class="fas fa-angle-up when-open" />
					<i class="fas fa-angle-down when-closed" />
					<span class="collapse-title">{{ textName }}</span>
				</span>
			</slot>
		</p>

		<div class="show-collapse">
			<b-collapse id="zone-collapse">
				<slot name="zone-collapse" />
			</b-collapse>
		</div>
	</div>
</template>

<script>
export default {
    name: 'VHeaderCollapse',
    props: {
        textName: {
            type: String,
            default: '',
            require: true,
        },
    },
};
</script>

<style lang="scss" scoped>
    @import '@/scss/variables.scss';

    .header-collapse {
        p {
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
        }

        .show {
            padding-bottom: 17px;
        }

        .collapse-title:hover {
          cursor: pointer;
        }
    }

    .collapsed > .when-open,
    .not-collapsed > .when-closed {
        display: none;
    }
</style>
