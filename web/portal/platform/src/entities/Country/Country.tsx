import SettingsApplications from '@mui/icons-material/SettingsApplications';
import EntityInterface from '@irontec/ivoz-ui/entities/EntityInterface';
import _ from '@irontec/ivoz-ui/services/translations/translate';
import defaultEntityBehavior from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import { getI18n } from 'react-i18next';
import { CountryProperties, CountryPropertyList } from './CountryProperties';
import selectOptions from './SelectOptions';
import { EntityValues } from '@irontec/ivoz-ui';

const properties: CountryProperties = {
  name: {
    label: _('Name'),
  },
  countryCode: {
    label: _('Country code'),
  },
};

const country: EntityInterface = {
  ...defaultEntityBehavior,
  icon: SettingsApplications,
  iden: 'Country',
  title: _('Country', { count: 2 }),
  path: '/countries',
  toStr: (row: CountryPropertyList<EntityValues>) => {
    const language = getI18n().language.substring(0, 2);
    const name = row.name as Record<string, string>;

    return name[language];
  },
  properties,
  acl: {
    ...defaultEntityBehavior.acl,
    iden: 'Countries',
  },
  selectOptions,
};

export default country;
