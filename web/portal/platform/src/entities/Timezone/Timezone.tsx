import { EntityValues } from '@irontec/ivoz-ui';
import defaultEntityBehavior from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import EntityInterface from '@irontec/ivoz-ui/entities/EntityInterface';
import _ from '@irontec/ivoz-ui/services/translations/translate';
import AccountTreeIcon from '@mui/icons-material/AccountTree';
import selectOptions from './SelectOptions';

const timezone: EntityInterface = {
  ...defaultEntityBehavior,
  icon: AccountTreeIcon,
  iden: 'Timezone',
  title: _('Timezone', { count: 2 }),
  path: '/timezones',
  acl: {
    ...defaultEntityBehavior.acl,
    iden: 'Timezones',
  },
  toStr: (row: EntityValues) => row.tz as string,
  selectOptions,
};

export default timezone;
