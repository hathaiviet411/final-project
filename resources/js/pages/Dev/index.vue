<template>
	<div class="dev">
		<b-col>
			<div class="dev__language">
				<h2>{{ $t('DEV.LANGUAGE') }}</h2>
			</div>
		</b-col>

		<b-col>
			<b-row>
				<b-col>
					<div :class="{ 'dev__btn-lang': true, 'dev__choose-lang': language === 'en' }">
						<b-button :disabled="isDisabledEnBtn" @click="setLanguage('en')">
							<b-img class="flag-icon" :src="English" />
							<span>{{ $t('DEV.ENGLISH') }}</span>
						</b-button>
					</div>
				</b-col>

				<b-col>
					<div :class="{ 'dev__btn-lang': true, 'dev__choose-lang': language === 'vi' }">
						<b-button :disabled="isDisabledVnBtn" @click="setLanguage('vi')">
							<b-img class="flag-icon" :src="Vietnam" />
							<span>{{ $t('DEV.VIETNAMESE') }}</span>
						</b-button>
					</div>
				</b-col>
			</b-row>
		</b-col>
	</div>
</template>

<script>
import Vietnam from '@/assets/images/vietnam.png';
import English from '@/assets/images/united-kingdom.png';

export default {
    name: 'PageDev',
    data() {
        return {
            Vietnam,
            English,

            isDisabledVnBtn: false,
            isDisabledEnBtn: false,
        };
    },
    computed: {
        language() {
            return this.$store.getters.language;
        },
    },
    methods: {
        setLanguage(lang) {
            if (lang === 'en') {
                this.isDisabledEnBtn = true;
                this.isDisabledVnBtn = false;
            } else if (lang === 'vi') {
                this.isDisabledEnBtn = false;
                this.isDisabledVnBtn = true;
            }

            this.$store.dispatch('app/setLanguage', lang)
                .then(() => {
                    this.$i18n.locale = lang;
                    this.$toast.success({
                        content: this.$t('TOAST.I18N.CHANGE_LANGUAGE.SUCCESS'),
                    });
                })
                .catch(() => {
                    this.$toast.error({
                        content: this.$t('TOAST.I18N.CHANGE_LANGUAGE.FAILED'),
                    });
                });
        },
    },
};
</script>

<style lang="scss" scoped>
    @import '@/scss/variables';

    .dev {
        &__language {
            text-align: center;
        }

        &__btn-lang {
            text-align: center;

            button {
                background-color: $cloud-burst;
                min-width: 200px;
                border: none;
                padding: 10px 0px 10px 0;

                span {
                    margin-left: 10px;
                    display: flexbox;
                    vertical-align: middle;
                    font-weight: 600;
                }

                &:active {
                    color: $cloud-burst !important;
                    background-color: $white !important;
                }
            }

            .flag-icon {
              max-width: 25px;
              max-height: 25px;
              vertical-align: middle;
            }
        }

        &__choose-lang {
            button {
                color: $cloud-burst;
                background-color: $white;
            }
        }
    }
</style>

