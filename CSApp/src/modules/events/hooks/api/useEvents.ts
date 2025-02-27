import ApiRoutes from '@modules/events/defs/api-routes';
import { Event } from '@modules/events/defs/types';
import useItems, { UseItems, UseItemsOptions, defaultOptions } from '@common/hooks/useItems';

export interface CreateOneInput {
  title: string;
  description: string;
  location: string;
  date: string;
  maxParticipants: number;
}

export interface UpdateOneInput {
  title?: string;
  description?: string;
  location?: string;
  date?: string;
  maxParticipants?: number;
  status?: 'active' | 'cancelled' | 'completed';
}

export type UpsertOneInput = CreateOneInput | UpdateOneInput;

const useEvents: UseItems<Event, CreateOneInput, UpdateOneInput> = (
  opts: UseItemsOptions = defaultOptions,
) => {
  const useItemsHook = useItems<Event, CreateOneInput, UpdateOneInput>(ApiRoutes, opts);
  return useItemsHook;
};

export default useEvents;
