// src/modules/events/components/partials/CreateEventForm.tsx
import { RHFTextField } from '@common/components/lib/react-hook-form';
import CreateCrudItemForm from '@common/components/partials/CreateCrudItemForm';
import Routes from '@common/defs/routes';
import { Event } from '@modules/events/defs/types';
import useEvents from '@modules/events/hooks/api/useEvents';
import { Grid } from '@mui/material';
import { UseFormReturn } from 'react-hook-form';
import * as Yup from 'yup';

const CreateEventForm = () => {
  const schema = Yup.object().shape({
    title: Yup.string().required('Title is required'),
    description: Yup.string().required('Description is required'),
    location: Yup.string().required('Location is required'),
    date: Yup.date().required('Date is required'),
    maxParticipants: Yup.number().required('Max participants is required').min(1),
  });

  const defaultValues = {
    title: '',
    description: '',
    location: '',
    date: '',
    maxParticipants: 1,
  };

  const onPostSubmit = async (_data: any, response: any, _methods: UseFormReturn<any>) => {
    if (response.success) {
      // Handle success
    }
  };

  return (
    <CreateCrudItemForm<Event, any>
      routes={Routes.Events}
      useItems={useEvents}
      schema={schema}
      defaultValues={defaultValues}
      onPostSubmit={onPostSubmit}
    >
      <Grid container spacing={3} sx={{ padding: 6 }}>
        <Grid item xs={6}>
          <RHFTextField name="title" label="Title" />
        </Grid>
        <Grid item xs={6}>
          <RHFTextField name="description" label="Description" />
        </Grid>
        <Grid item xs={6}>
          <RHFTextField name="location" label="Location" />
        </Grid>
        <Grid item xs={6}>
          <RHFTextField name="date" label="Date" type="datetime-local" />
        </Grid>
        <Grid item xs={6}>
          <RHFTextField name="maxParticipants" label="Max Participants" type="number" />
        </Grid>
      </Grid>
    </CreateCrudItemForm>
  );
};

export default CreateEventForm;
