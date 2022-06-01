import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';

const propTypes = {
    children: PropTypes.node.isRequired,
};

const TabWrap = ({ children }) => children;

// const TabWrap = ({ children, permissions, permission }) => {
//     if (!permission) return children;
//     return <>{permissions.some((v) => permission.includes(v)) ? children : null}</>;
// };

TabWrap.propTypes = propTypes;

export default withTagDefaultProps(TabWrap);
