const initialState = {
    title: 'Dashboard',
    statusEntries: [],
    locationEntries: [],
}

const viewreducer = ( state = initialState, action ) => {
    switch ( action.type ) {
        case 'SET_TITLE':
            return { ...state, ...{ title: action.payload } }
        case 'SET_STATUSENTRIES':
            return { ...state, ...{ statusEntries: action.payload }}
        case 'SET_LOCATIONENTRIES':
            return { ...state, ...{ locationEntries: action.payload }}
        default:
            return state
    }
}

export default viewreducer