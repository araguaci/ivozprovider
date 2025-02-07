import defaultEntityBehavior from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import { SelectOptionsType } from '@irontec/ivoz-ui/entities/EntityInterface';
import { CallForwardSettingPropertiesList } from './CallForwardSettingProperties';
import { DropdownChoices } from '@irontec/ivoz-ui';
import store from 'store';

const CallForwardSettingSelectOptions: SelectOptionsType = ({
  callback,
  cancelToken,
}): Promise<unknown> => {
  const entities = store.getState().entities.entities;
  const CallForwardSetting = entities.CallForwardSetting;

  return defaultEntityBehavior.fetchFks(
    CallForwardSetting.path,
    ['id', 'name'],
    (data: CallForwardSettingPropertiesList) => {
      const options: DropdownChoices = [];
      for (const item of data) {
        options.push({ id: item.id as number, label: item.name as string });
      }

      callback(options);
    },
    cancelToken
  );
};

export default CallForwardSettingSelectOptions;
