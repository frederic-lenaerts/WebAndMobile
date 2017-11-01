import React from 'react'
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
} from 'material-ui/Table'

const Row = ( props ) => (
    <TableRow >
        <TableRowColumn >
            { props.entry.id }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.name }
        </TableRowColumn>
    </TableRow>
)

const Rows = ( props ) => props.entries.map( e => (
    <Row entry={ e } key={ e.id } />
))

const LocationsTable = ( props ) => (
    <Table 
        fixedHeader={ true }
        selectable={ false }
        multiSelectable={ false }>
        <TableHeader
            displaySelectAll={ false }
            adjustForCheckbox={ true }
            enableSelectAll={ false}
        >
            <TableRow>
                <TableHeaderColumn>Id</TableHeaderColumn>
                <TableHeaderColumn>Name</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody displayRowCheckbox={ false }>
            <Rows entries={ props.entries } />
        </TableBody>
    </Table>
)

export default LocationsTable
