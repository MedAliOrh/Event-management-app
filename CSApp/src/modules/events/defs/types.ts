import { CrudObject } from '@common/defs/types';

export interface Event extends CrudObject {
  title: string;
  description: string;
  location: string;
  date: string;
  maxParticipants: number;
  status: 'active' | 'cancelled' | 'completed';
}
