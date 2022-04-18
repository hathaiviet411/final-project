<template>
	<div>
		<ul class="display-menu" :style="toggole ? `position: fixed;` : 'position: relative'">
			<router-link
				v-for="(itemRouter, indexRouter) in routes"
				:key="indexRouter"
				:to="itemRouter.path"
			>
				<li :class="`item router-item-${itemRouter.meta.title}`">
					<div>
						<i :class="itemRouter.meta.icon" />
						<span>{{ $t(itemRouter.meta.title) }}</span>
					</div>
					<ul v-if="itemRouter.children.length > 1" class="sub-menu">
						<router-link
							v-for="(sub) in itemRouter['children']"
							:key="`sub-menu-${sub['meta']['title']}`"
							:to="`${itemRouter.path}/${sub['path']}`"
						>
							<span>{{ $t(sub['meta']['title']) }}</span>
						</router-link>
					</ul>

					<ul v-else />
				</li>
			</router-link>
		</ul>
	</div>
</template>

<script>
export default {
    name: 'MenuSidebar',
    props: {
        routes: {
            type: Array,
            require: true,
            default: function() {
                return [];
            },
        },
        toggole: {
            type: Boolean,
            require: true,
            default: true,
        },
    },
};
</script>

<style lang="scss" scoped>
    @import '@/scss/variables.scss';

    .display-menu {
        height: 100%;
        width: 200px;
        padding-top: 30px;
        list-style-type: disc;
        margin-block-start: 0;
        margin-block-end: 0;
        margin-inline-start: 0;
        margin-inline-end: 0;
        padding-inline-start: 0;
        text-align: center;

        a {
            width: 200px;
            display: block;

            li {
                display: inline-flex;

                i {
                    display: block;
                    margin-bottom: 5px;
                    font-size: 30px;
                    padding-top: 10px;
                }

                text-decoration: none;
                list-style-type: none;
                margin-bottom: 20px;
                font-size: 14px;

                color: $white;
            }

            ul {
                display: none;
            }

            &:hover {
                text-decoration: none;

                ul {
                    z-index: 99;

                    padding: 0;

                    position: absolute;
                    display: block;

                    left: 200px;

                    background-color: $cloud-burst;

                    a {
                        display: inline-flex;

                        width: 200px;

                        span {
                            width: 100%;
                            text-align: left;

                            padding: 10px 10px;

                            color: $white;
                        }

                        &:hover {
                            background-color: $white;
                        }
                    }
                }
            }
        }

        a.router-link-active {
            background-color: $white;

            li {
                font-weight: bold;
                color: $black;
            }
        }
    }
</style>
