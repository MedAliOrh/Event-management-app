import Routes from '@common/defs/routes';
import ItemsTable from '@common/components/partials/ItemsTable';
import { Event } from '@modules/events/defs/types';
import useEvents from '@modules/events/hooks/api/useEvents';
import { GridColumns } from '@mui/x-data-grid';
import dayjs from 'dayjs';
import { useTranslation } from 'react-i18next';
import { useEffect, useState, useMemo, useCallback } from 'react';
import Namespaces from '@common/defs/namespaces';

interface Row {
  id: number;
  title: string;
  date: string;
  location: string;
  status: string;
}

const EventsTable = () => {
  const { t, i18n } = useTranslation(['event']);

  const columns: GridColumns<Row> = useMemo(
    () => [
      { field: 'id', headerName: 'ID', width: 100 },
      { field: 'title', headerName: t('event:list.title'), flex: 1 },
      {
        field: 'date',
        headerName: t('event:list.date'),
        type: 'dateTime',
        flex: 1,
        renderCell: (params) => dayjs(params.row.date).format('DD/MM/YYYY HH:mm'),
      },
      { field: 'location', headerName: t('event:list.location'), flex: 1 },
      { field: 'status', headerName: t('event:list.status'), flex: 1 },
    ],
    [t],
  );

  const [translatedColumns, setTranslatedColumns] = useState<GridColumns<Row>>(columns);

  useEffect(() => {
    setTranslatedColumns(columns);
  }, [t, i18n.language]);

  const itemToRow = useCallback(
    (item: Event): Row => ({
      id: item.id,
      title: item.title,
      date: item.date,
      location: item.location,
      status: item.status,
    }),
    [],
  );

  return (
    <ItemsTable<Event, any, any, Row>
      namespace={Namespaces.Events}
      routes={Routes.Events}
      useItems={useEvents}
      columns={translatedColumns}
      itemToRow={itemToRow}
      showEdit={() => true}
      showDelete={() => true}
      showLock
      exportable
      density="standard"
      sortModel={[{ field: 'createdAt', sort: 'desc' }]}
      filterModel={{ items: [] }}
    />
  );
};

export default EventsTable;
