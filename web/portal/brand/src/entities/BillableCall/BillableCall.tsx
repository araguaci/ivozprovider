import ChatBubbleIcon from '@mui/icons-material/ChatBubble';
import EntityInterface from '@irontec/ivoz-ui/entities/EntityInterface';
import _ from '@irontec/ivoz-ui/services/translations/translate';
import defaultEntityBehavior from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import selectOptions from './SelectOptions';
import Form from './Form';
import { foreignKeyGetter } from './ForeignKeyGetter';
import { BillableCallProperties } from './BillableCallProperties';
import foreignKeyResolver from './ForeignKeyResolver';

const properties: BillableCallProperties = {
  callid: {
    label: _('Call ID'),
    maxLength: 128,
  },
  startTime: {
    label: _('Start time'),
    format: 'date-time',
  },
  duration: {
    label: _('Duration'),
  },
  caller: {
    label: _('Caller'),
  },
  callee: {
    label: _('Callee'),
    maxLength: 128,
  },
  cost: {
    label: _('Cost'),
  },
  price: {
    label: _('Price'),
  },
  carrierName: {
    label: _('Carrier', { count: 1 }),
  },
  destinationName: {
    label: _('Destination', { count: 1 }),
    maxLength: 100,
  },
  ratingPlanName: {
    label: _('Rating plan'),
  },
  endpointType: {
    label: _('Endpoint Type'),
    enum: {
      RetailAccount: _('Retail Account', { count: 1 }),
      ResidentialDevice: _('Residential Device', { count: 1 }),
      User: _('User', { count: 1 }),
      Friend: _('Friend', { count: 1 }),
      Fax: _('Fax', { count: 1 }),
    },
  },
  endpointId: {
    label: _('Endpoint id'),
  },
  endpointName: {
    label: _('Endpoint name'),
  },
  direction: {
    label: _('Direction'),
    enum: {
      inbound: _('Inbound'),
      outbound: _('Outbound'),
    },
  },
  id: {
    label: _('Id'),
  },
  company: {
    label: _('Client'),
  },
  carrier: {
    label: _('Carrier', { count: 1 }),
  },
  destination: {
    label: _('Destination', { count: 1 }),
  },
  ratingPlanGroup: {
    label: _('Rating Plan Group', { count: 1 }),
  },
  invoice: {
    label: _('Invoice', { count: 1 }),
    null: _('Unassigned'),
  },
  ddi: {
    label: _('DDI', { count: 1 }),
  },
  ddiProvider: {
    label: _('DDI Provider', { count: 1 }),
    null: _('Unassigned'),
  },
};

const BillableCall: EntityInterface = {
  ...defaultEntityBehavior,
  icon: ChatBubbleIcon,
  iden: 'BillableCall',
  title: _('External call', { count: 2 }),
  path: '/billable_calls',
  toStr: (row: any) => row.id,
  properties,
  columns: [
    'startTime',
    'company',
    'direction',
    'caller',
    'callee',
    'duration',
    'price',
    'cost',
    'invoice',
  ],
  acl: {
    read: true,
    detail: true,
    create: false,
    update: false,
    delete: false,
  },
  selectOptions,
  foreignKeyResolver,
  foreignKeyGetter,
  Form,
};

export default BillableCall;
