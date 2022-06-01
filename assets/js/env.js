const dev = {
    stripe: 'pk_test_51Hz7D6KUrStSikXwqhQpERlIiL7iXQhDX2zD8WQRkpp8IzKgaFSlW2PSCJQneSfVKJeWOhezxm1r1iFzlxfShQwG00CJITrbYQ',
};

const prod = {
    stripe: 'pk_live_51Hz7D6KUrStSikXwHnTcZf1QGLbu982sYYY4ccXE953VQodcWy4WJeMdgyM31FpOmKMGdetWwJ06PPYGlAY8g18d00ptUQbeBN',
};

export const getConfigKey = (key) => (process.env.NODE_ENV === 'development' ? dev[key] : prod[key]);
