import React, { useState, useEffect } from 'react';
import { Box, Container, Typography, Button } from '@mui/material';
import { Link } from 'react-router-dom';
import { styled } from '@mui/material/styles';
import { getPractitioners } from '../../services/api';
import PractitionerChat from './PractitionerChat'; // Import the chat component

// Styled components
const HeroSection = styled(Box)(({ theme }) => ({
    background: '#f5f5f5',
    padding: theme.spacing(8, 0),
    textAlign: 'center',
    marginBottom: theme.spacing(6),
}));

const HeroImage = styled('img')({
    maxWidth: '100%',
    height: 'auto',
    marginTop: '2rem',
    borderRadius: '8px',
});

const CategorySection = styled(Box)(({ theme }) => ({
    marginBottom: theme.spacing(8),
}));

const CategoryTitle = styled(Typography)(({ theme }) => ({
    marginBottom: theme.spacing(4),
    textAlign: 'right',
    color: '#333',
    fontWeight: 'bold',
}));

const ServicesGrid = styled(Box)(({ theme }) => ({
    display: 'grid',
    gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
    gap: theme.spacing(3),
    marginTop: theme.spacing(2),
}));

const ServiceCard = styled(Box)(() => ({
    borderRadius: '8px',
    overflow: 'hidden',
    boxShadow: '0 4px 6px rgba(0,0,0,0.1)',
    transition: 'transform 0.2s',
    cursor: 'pointer',
    '&:hover': {
        transform: 'translateY(-5px)',
    },
}));

const ServiceImage = styled('img')({
    width: '100%',
    height: '200px',
    objectFit: 'cover',
});

const ServiceTitle = styled(Typography)(() => ({
    padding: '1rem',
    textAlign: 'center',
    backgroundColor: '#fff',
}));

const PractitionersShowcase = () => {
    const [practitioners, setPractitioners] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [selectedPractitioner, setSelectedPractitioner] = useState(null); // Track selected practitioner
    const [chatOpen, setChatOpen] = useState(false); // Track if chat is open

    useEffect(() => {
        const fetchPractitioners = async () => {
            try {
                const response = await getPractitioners();
                setPractitioners(response.data);
            } catch (err) {
                setError(err);
            } finally {
                setLoading(false);
            }
        };

        fetchPractitioners();
    }, []);

    const handlePractitionerClick = (practitioner) => {
        setSelectedPractitioner(practitioner);
        setChatOpen(true);
    };

    const handleChatClose = () => {
        setChatOpen(false);
        setSelectedPractitioner(null);
    };

    if (loading) {
        return <Typography>Loading practitioners...</Typography>;
    }

    if (error) {
        return <Typography color="error">Error: {error.message}</Typography>;
    }

    return (
        <Box sx={{ direction: 'rtl' }}>
            <Box sx={{ position: 'fixed', top: 20, left: 20, ZIndex: 1000, direction: 'ltr' }}>
                <Box sx={{ display: 'flex', gap: 1, flexDirection: 'column' }}>
                    <Button
                        component={Link}
                        to="/admin"
                        variant="contained"
                        color="primary"
                        sx={{ textDecoration: 'none' }}
                    >
                        إدارة المتخصصين
                    </Button>
                    <Button
                        component={Link}
                        to="/services"
                        variant="outlined"
                        color="secondary"
                        sx={{ textDecoration: 'none' }}
                    >
                        الخدمات
                    </Button>
                </Box>
            </Box>
            <HeroSection>
                <Container>
                    <Typography variant="h3" component="h1" gutterBottom>
                        المتخصصون في MediBook
                    </Typography>
                    <Typography variant="h5" color="text.secondary" gutterBottom>
                        نخبة من المتخصصين لتقديم أفضل رعاية طبية
                    </Typography>
                    <HeroImage
                        src="/images/6421964fc62f1e964e6f7f91e67affbdc165d933.png"
                        alt="MediBook Practitioners"
                    />
                </Container>
            </HeroSection>

            <Container>
                <CategorySection>
                    <CategoryTitle variant="h4">
                        المتخصصون لدينا
                    </CategoryTitle>
                    <ServicesGrid>
                        {practitioners.map((practitioner) => (
                            <ServiceCard key={practitioner.id} onClick={() => handlePractitionerClick(practitioner)}>
                                <ServiceImage
                                    src={practitioner.image ? practitioner.image : '/images/6421964fc62f1e964e6f7f91e67affbdc165d933.png'}
                                    alt={practitioner.specialization}
                                    onError={(e) => {
                                        console.error('Image load error:', e.target.src);
                                        e.target.src = '/images/6421964fc62f1e964e6f7f91e67affbdc165d933.png';
                                    }}
                                />
                                <ServiceTitle variant="h6">
                                    متخصص #{practitioner.id}
                                </ServiceTitle>
                                <Box sx={{ padding: '1rem' }}>
                                    <Typography variant="body1" color="text.secondary" sx={{ mt: 1 }}>
                                        التخصص: {practitioner.specialization}
                                    </Typography>
                                    <Typography variant="body2" color="text.secondary" sx={{ mt: 1 }}>
                                        المؤهلات: {practitioner.qualifications || 'null'}
                                    </Typography>
                                    <Typography variant="body2" color="text.secondary" sx={{ mt: 1 }}>
                                        ساعات العمل: {practitioner.working_hours}
                                    </Typography>
                                    <Typography variant="body2" color="primary" sx={{ mt: 1 }}>
                                        معلومات التواصل: {practitioner.contact}
                                    </Typography>
                                </Box>
                            </ServiceCard>
                        ))}
                    </ServicesGrid>
                </CategorySection>
            </Container>
            <PractitionerChat
                open={chatOpen}
                onClose={handleChatClose}
                practitioner={selectedPractitioner}
            />
        </Box>
    );
};

export default PractitionersShowcase;