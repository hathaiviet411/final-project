import { mount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import router from '@/router';
import UserManagementCreate from '@/pages/UserManagement/Create';

describe('TEST PAGE USER MANAGEMENT CREATE', () => {
    const mocks = {
        $bus: {
            on: jest.fn(),
            once: jest.fn(),
            off: jest.fn(),
            emit: jest.fn(),
        },
    };

    const backToUserManagementIndex = jest.fn();
    const initData = jest.fn();
    const validation = jest.fn();

    const localVue = createLocalVue();
    const wrapper = mount(UserManagementCreate, {
        localVue,
        router,
        store,
        mocks,
        stubs: {
            BIcon: true,
        },
        methods: {
            backToUserManagementIndex,
            initData,
            validation,
        },
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    test('Test component call api in hook created', async() => {
        expect(initData).toHaveBeenCalled();
    });

    test('Test component render data', async() => {
        const isProcess = false;
        const user_role = null;
        const user_role_options = [];
        const user_id = '';
        const base = null;
        const base_options = [];
        const user_name = '';
        const pwd = '';
        const overlay = {
            show: false,
            variant: 'light',
            opacity: 1,
            blur: '1rem',
            rounded: 'sm',
        };

        expect(wrapper.vm.isProcess).toEqual(isProcess);
        expect(wrapper.vm.user_role).toEqual(user_role);
        expect(wrapper.vm.user_role_options).toEqual(user_role_options);
        expect(wrapper.vm.user_id).toEqual(user_id);
        expect(wrapper.vm.base).toEqual(base);
        expect(wrapper.vm.base_options).toEqual(base_options);
        expect(wrapper.vm.user_name).toEqual(user_name);
        expect(wrapper.vm.pwd).toEqual(pwd);
        expect(wrapper.vm.overlay).toEqual(overlay);
    });

    test('Test component render form create', async() => {
        const UserCreate = wrapper.find('.user-management-create');
        expect(UserCreate.exists()).toBe(true);

        const Body = UserCreate.find('.content-body');
        expect(Body.exists()).toBe(true);

        const ListInput = wrapper.findAll('.input-row');
        expect(ListInput.length).toEqual(6);

        const UserRoleLabel = wrapper.find('label.user-role');
        expect(UserRoleLabel.exists()).toBe(true);
        expect(UserRoleLabel.text()).toEqual('USER_MANAGEMENT.USER_ROLE');

        const BaseLabel = wrapper.find('label.base');
        expect(BaseLabel.exists()).toBe(true);
        expect(BaseLabel.text()).toEqual('USER_MANAGEMENT.BASE');

        const UserIdLabel = wrapper.find('label.user-id');
        expect(UserIdLabel.exists()).toBe(true);
        expect(UserIdLabel.text()).toEqual('USER_MANAGEMENT.USER_ID');

        const UserNameLabel = wrapper.find('label.user-name');
        expect(UserNameLabel.exists()).toBe(true);
        expect(UserNameLabel.text()).toEqual('USER_MANAGEMENT.USER_NAME');

        const PasswordLabel = wrapper.find('label.pwd');
        expect(PasswordLabel.exists()).toBe(true);
        expect(PasswordLabel.text()).toEqual('USER_MANAGEMENT.PASSWORD');

        const FunctionalButtons = wrapper.find('.footer-functional-buttons');
        const ListButton = FunctionalButtons.findAll('button');
        expect(ListButton.length).toEqual(2);

        const ButtonBack = FunctionalButtons.find('button#btn-back');
        expect(ButtonBack.exists()).toBe(true);
        expect(ButtonBack.text()).toEqual('BUTTON.BACK');

        const ButtonRegister = FunctionalButtons.find('button#btn-save');
        expect(ButtonRegister.exists()).toBe(true);
        expect(ButtonRegister.text()).toEqual('BUTTON.REGISTER');
    });

    test('Test click button back', async() => {
        const ButtonBack = wrapper.find('button#btn-back');
        expect(ButtonBack.exists()).toBe(true);

        await ButtonBack.trigger('click');

        expect(backToUserManagementIndex).toHaveBeenCalled();
    });

    test('Test click button save', async() => {
        const ButtonSave = wrapper.find('button#btn-save');
        expect(ButtonSave.exists()).toBe(true);

        await ButtonSave.trigger('click');

        expect(validation).toHaveBeenCalled();
    });
});
