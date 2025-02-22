import { autoSelectOptions } from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import { ForeignKeyGetterType } from '@irontec/ivoz-ui/entities/EntityInterface';
import LanguageSelectOptions from 'entities/Language/SelectOptions';
import { DdiPropertyList } from './DdiProperties';

export const foreignKeyGetter: ForeignKeyGetterType = async (
  props
): Promise<any> => {
  const { cancelToken, entityService } = props;
  const skip = props.skip || [];
  skip.push('language');

  const response: DdiPropertyList<unknown> = {};

  const promises = autoSelectOptions({
    entityService,
    cancelToken,
    response,
    skip,
  });

  promises[promises.length] = LanguageSelectOptions({
    callback: (options: any) => {
      response.language = options;
    },
    cancelToken,
  });

  await Promise.all(promises);

  return response;
};
