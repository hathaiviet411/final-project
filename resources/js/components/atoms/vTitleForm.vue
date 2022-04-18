<template>
	<div class="title-form">
		<div class="title-form__straight" />
		<div class="title-form__text">
			<slot>
				<span>Title Form</span>
			</slot>
		</div>
	</div>
</template>

<script>
export default {
    name: 'VTitleForm',
};
</script>

<style lang="scss" scoped>
@import '@/scss/variables.scss';

.title-form {
    display: flex;

    &__straight {
        width: 8px;
        line-height: 1rem;
        background-color: $white;
    }

    &__text {
        font-size: 1rem;
        margin-left: 10px;
        font-weight: 500;
    }
}
</style>
