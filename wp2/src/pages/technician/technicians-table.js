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
            { props.entry.name }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.location.name }
        </TableRowColumn>
    </TableRow>
)

const Rows = ( props ) => props.entries.map( e => (
    <Row entry={ e } key={ e.id } />
))

const TechniciansTable = ( props ) => (
    <Table 
        fixedHeader={ true }
        selectable={ false }
        multiSelectable={ false }>
        <TableHeader
            displaySelectAll={ false }
            adjustForCheckbox={ true }
            enableSelectAll={ false}
        >
            <TableRow >
                <TableHeaderColumn>Name</TableHeaderColumn>
                <TableHeaderColumn>Location</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody displayRowCheckbox={ false }>
            <Rows entries={ props.entries } />
        </TableBody>
    </Table>
)

export default TechniciansTable
