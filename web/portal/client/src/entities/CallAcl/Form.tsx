import defaultEntityBehavior, {
  EntityFormProps,
  FieldsetGroups,
} from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import _ from '@irontec/ivoz-ui/services/translations/translate';

const Form = (props: EntityFormProps): JSX.Element => {
  const DefaultEntityForm = defaultEntityBehavior.Form;

  const groups: Array<FieldsetGroups> = [
    {
      legend: _('ACL data'),
      fields: ['name', 'defaultPolicy'],
    },
  ];

  return <DefaultEntityForm {...props} groups={groups} />;
};

export default Form;
