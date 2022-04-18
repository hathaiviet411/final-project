import { mount, createLocalVue } from '@vue/test-utils';
import store from '@/store';
import router from '@/router';
import UserManagementIndex from '@/pages/UserManagement/Index';

describe('TEST PAGE USER MANAGEMENT LIST', () => {
    const mocks = {
        $bus: {
            on: jest.fn(),
            once: jest.fn(),
            off: jest.fn(),
            emit: jest.fn(),
        },
    };

    const localVue = createLocalVue();
    const wrapper = mount(UserManagementIndex, {
        localVue,
        router,
        store,
        mocks,
        stubs: {
            BIcon: true,
        },
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    test('Test component render header page', async() => {
        const Header = wrapper.find('.user-management__header-page');
        expect(Header.exists()).toBe(true);

        const HeaderText = Header.text();
        expect(HeaderText).toEqual('PAGE_TITLE.USER_MANAGEMENT');
    });

    test('Test component render button register', async() => {
        const ZoneRegister = wrapper.find('.user-management__register-btn');
        expect(ZoneRegister.exists()).toBe(true);

        const Button = wrapper.find('button');
        expect(Button.exists()).toBe(true);
        expect(Button.classes('maintenance-btn-default')).toBe(true);
        expect(Button.classes('maintenance-pdf-btn')).toBe(true);
        expect(Button.text()).toEqual('BUTTON.REGISTER');
    });

    test('Test component render filter', async() => {
        const ZoneFilter = wrapper.find('.user-management__zone-filter');
        expect(ZoneFilter.exists()).toBe(true);

        const Filter = wrapper.find('.organisms-user-management-filter');
        expect(Filter.exists()).toBe(true);

        const ButtonClear = wrapper.find('.text-clear-all');
        expect(ButtonClear.exists()).toBe(true);

        await ButtonClear.trigger('click');
        expect(wrapper.vm.$bus.emit).toHaveBeenCalledWith(
            'sendDataFilterUser',
            {
                isCheck: {
                    user_id: false,
                    user_name: false,
                },
                user_id: '',
                user_name: '',
            }
        );

        const ListFilter = Filter.findAll('.zone-input');
        expect(ListFilter.length).toEqual(2);

        let indexFilter = 0;
        const lenFilter = ListFilter.length;
        const LabelFilter = [
            'USER_MANAGEMENT.USER_ID',
            'USER_MANAGEMENT.USER_NAME',
        ];

        while (indexFilter < lenFilter) {
            const InputGroupPrependList = ListFilter.at(indexFilter).findAll('.input-group-prepend');

            let indexPrepend = 0;
            const lenPrepend = InputGroupPrependList.length;

            while (indexPrepend < lenPrepend) {
                const prepend = InputGroupPrependList.at(indexPrepend);

                if (indexPrepend === 0) {
                    const Checkbox = prepend.find('input');
                    expect(Checkbox.exists()).toBe(true);
                    expect(Checkbox.attributes('type')).toEqual('checkbox');

                    await Checkbox.trigger('click');
                    expect(wrapper.vm.$bus.emit).toHaveBeenCalled();
                }

                if (indexPrepend === 1) {
                    const Span = prepend.find('span');
                    const Text = Span.text();

                    expect(Text).toEqual(LabelFilter[indexFilter]);
                }

                indexPrepend++;
            }

            indexFilter++;
        }

        const ButtonApplyFilter = Filter.find('.zone-btn-apply');
        expect(ButtonApplyFilter.exists()).toBe(true);
        expect(ButtonApplyFilter.find('button').exists()).toBe(true);
        expect(ButtonApplyFilter.find('button').text()).toEqual('BUTTON.APPLY');
    });

    test('Test component render table', async() => {
        const ZoneTable = wrapper.find('.user-management__table');
        expect(ZoneTable.exists()).toBe(true);

        const DATA = [
            {
                id: 1,
                user_code: 111111,
                department_id: 1,
                user_name: 'Super Admin',
                role_name: 'headquarter',
                departments_name: 'Tokyo',
                model_type: 'App\\Models\\User',
            },
            {
                id: 2,
                user_code: 666666,
                department_id: 1,
                user_name: 'User Team',
                role_name: 'team',
                departments_name: 'Tokyo',
                model_type: 'App\\Models\\User',
            },
        ];

        const TableUserManagement = wrapper.find('#table-user-management');
        expect(TableUserManagement.exists()).toBe(true);

        await wrapper.setData({ vItems: DATA });

        const TableHeader = wrapper.find('thead');
        const ListHeader = TableHeader.findAll('th');
        expect(ListHeader.length).toEqual(6);

        const ListHeaderText = [
            'USER_MANAGEMENT.USER_ROLE (Click to sort Ascending)',
            'USER_MANAGEMENT.BASE (Click to sort Ascending)',
            'USER_MANAGEMENT.USER_ID (Click to sort Ascending)',
            'USER_MANAGEMENT.USER_NAME (Click to sort Ascending)',
            '',
            '',
        ];

        for (let th = 0; th < ListHeader.length; th++) {
            expect(ListHeader.at(th).text()).toEqual(ListHeaderText[th]);
        }

        const TableBody = wrapper.find('tbody');
        const ListRow = TableBody.findAll('tr');
        expect(ListRow.length).toEqual(2);

        for (let tr = 0; tr < ListRow.length; tr++) {
            const TR = ListRow.at(tr);
            const ListTD = TR.findAll('td');

            expect(ListTD.length).toEqual(6);
            expect(ListTD.at(0).text()).toEqual(DATA[tr].role_name + '');
            expect(ListTD.at(1).text()).toEqual(DATA[tr].departments_name + '');
            expect(ListTD.at(2).text()).toEqual(DATA[tr].user_code + '');
            expect(ListTD.at(3).text()).toEqual(DATA[tr].user_name + '');
            expect(ListTD.at(4).text()).toEqual('BUTTON.EDIT');
            expect(ListTD.at(5).text()).toEqual('BUTTON.DELETE');
        }
    });
});
