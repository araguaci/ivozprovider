import { QueuePropertyList } from './QueueProperties';
import { ForeignKeyGetterType } from '@irontec/ivoz-ui/entities/EntityInterface';
import { autoSelectOptions } from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import entities from '../index';
import EnabledVoicemailSelectOptions from 'entities/Voicemail/EnabledVoicemailSelectOptions';

export const foreignKeyGetter: ForeignKeyGetterType = async ({ cancelToken, entityService }): Promise<any> => {

    const response: QueuePropertyList<Array<string | number>> = {};

    const promises = autoSelectOptions({
        entities,
        entityService,
        cancelToken,
        response,
        skip: [
            'timeoutVoicemail',
            'fullVoicemail',
        ]
    });

    promises[promises.length] = EnabledVoicemailSelectOptions({
        callback: (options: any) => {
            response.timeoutVoicemail = options;
            response.fullVoicemail = options;
        },
        cancelToken
    });

    await Promise.all(promises);

    return response;
};