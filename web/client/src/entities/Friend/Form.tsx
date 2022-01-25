import defaultEntityBehavior, { EntityFormProps, FieldsetGroups } from 'lib/entities/DefaultEntityBehavior';
import _ from 'lib/services/translations/translate';
import useFkChoices from './useFkChoices';

const Form = (props: EntityFormProps): JSX.Element => {

    const edit = props.edit || false;
    const DefaultEntityForm = defaultEntityBehavior.Form;
    const fkChoices = useFkChoices();

    const groups: Array<FieldsetGroups | false> = [
        {
            legend: _('Basic Configuration'),
            fields: [
                'directConnectivity',
                'priority',
                'description',
                'name',
                'password',
                'transport',
                'ip',
                'port',
                'alwaysApplyTransformations',
            ]
        },
        edit && {
            legend: _('Geographic Configuration'),
            fields: [
                'language',
                'transformationRuleSet',
            ]
        },
        edit && {
            legend: _('Outgoing Configuration'),
            fields: [
                'callAcl',
                'outgoingDdi',
            ]
        },
        {
            legend: _('Advanced Configuration'),
            fields: [
                edit && 'fromUser',
                edit && 'fromDomain',
                edit && 'allow',
                edit && 'ddiIn',
                edit && 't38Passthrough',
                edit && 'rtpEncryption',
                'multiContact',
            ]
        },
        {
            legend: '',
            fields: [
                edit && 'statusIcon',
            ]
        },
    ];

    return (<DefaultEntityForm {...props} fkChoices={fkChoices} groups={groups} />);
}

export default Form;