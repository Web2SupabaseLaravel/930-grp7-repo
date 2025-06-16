import React, { useState, useEffect } from 'react';
import { Box, Container, Typography, Button } from '@mui/material';
import { Link } from 'react-router-dom';
import { styled } from '@mui/material/styles';
import { getServices, getServicePractitioners, getPractitioners } from '../../services/api';
import PractitionerModal from '../practitioners/PractitionerModal';

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

const ServiceTitle = styled(Typography)({
    padding: '1rem',
    textAlign: 'center',
    backgroundColor: '#fff',
});

// Function to get different default images for each service
const getDefaultServiceImage = (serviceId) => {
    let imageName = '';
    if (serviceId === 4) {
        imageName = 'bloodtest.jpg';
    } else if (serviceId === 7) {
        imageName = 'hearttest.jpg';
    } else {
        const images = [
            '6421964fc62f1e964e6f7f91e67affbdc165d933.png',
            'bloodtest.jpg',
            'header.jpg',
            'hearttest.jpg',
            'massage.avif',
            'massage2.avif',
            'massage3.avif',
            'physicaltherapy.jpg'
        ];
        images.sort();
        const imageIndex = (serviceId - 1) % images.length;
        imageName = images[imageIndex];
    }
    return `/images/${imageName}`;
};

const ServicesShowcase = () => {
    const [services, setServices] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    const [modalOpen, setModalOpen] = useState(false);
    const [selectedService, setSelectedService] = useState(null);
    const [practitioners, setPractitioners] = useState([]);
    const [practitionersLoading, setPractitionersLoading] = useState(false);

    useEffect(() => {
        const fetchServices = async () => {
            try {
                const response = await getServices();
                setServices(response.data);
            } catch (err) {
                setError(err);
            } finally {
                setLoading(false);
            }
        };

        fetchServices();
    }, []);

    const handleServiceClick = async (service) => {
        setSelectedService(service);
        setModalOpen(true);
        setPractitionersLoading(true);
        try {
            const response = await getServicePractitioners(service.id);
            setPractitioners(response.data);
        } catch (err) {
            console.error('Error fetching practitioners:', err);
            setPractitioners([]);
        } finally {
            setPractitionersLoading(false);
        }
    };

    const handleAllPractitionersClick = async () => {
        setSelectedService(null);
        setModalOpen(true);
        setPractitionersLoading(true);
        try {
            const response = await getPractitioners();
            setPractitioners(response.data);
        } catch (err) {
            console.error('Error fetching all practitioners:', err);
            setPractitioners([]);
        } finally {
            setPractitionersLoading(false);
        }
    };

    const handleCloseModal = () => {
        setModalOpen(false);
        setSelectedService(null);
        setPractitioners([]);
    };

    if (loading) {
        return <Typography>جاري تحميل الخدمات...</Typography>;
    }

    if (error) {
        return <Typography color="error">خطأ: {error.message}</Typography>;
    }

    return (
        <Box sx={{ direction: 'rtl' }}>
            <Box sx={{ position: 'fixed', top: 20, left: 20, zIndex: 1000, direction: 'ltr' }}>
                <Box sx={{ display: 'flex', gap: 1, flexDirection: 'column' }}>
                    <Button
                        component={Link}
                        to="/admin"
                        variant="contained"
                        color="primary"
                        sx={{ textDecoration: 'none' }}
                    >
                        إدارة الخدمات
                    </Button>
                    <Button
                        onClick={handleAllPractitionersClick}
                        variant="outlined"
                        color="secondary"
                        sx={{ textDecoration: 'none' }}
                    >
                        المتخصصون
                    </Button>
                </Box>
            </Box>

            <HeroSection>
                <Container>
                    <Typography variant="h3" component="h1" gutterBottom>
                        مرحبا بكم في MediBook
                    </Typography>
                    <Typography variant="h5" color="text.secondary" gutterBottom>
                        حيث الرعاية تبدأ بالاهتمام وتنتهي بالشفاء
                    </Typography>
                    <HeroImage
                        src="/images/header.jpg"
                        alt="MediBook Welcome"
                    />
                </Container>
            </HeroSection>

            <Container>
                <CategorySection>
                    <CategoryTitle variant="h4">
                        خدماتنا الطبية
                    </CategoryTitle>
                    <ServicesGrid>
                        {services.map((service) => (
                            <ServiceCard key={service.id} onClick={() => handleServiceClick(service)}>
                                <ServiceImage
                                    src={service.image ? `/images/${service.image}` : getDefaultServiceImage(service.id)}
                                    alt={service.name}
                                    onError={(e) => {
                                        console.error('Image load error:', e.target.src);
                                        e.target.src = getDefaultServiceImage(service.id);
                                    }}
                                />
                                <Box sx={{ padding: '1rem' }}>
                                    <ServiceTitle variant="h6">
                                        {service.name}
                                    </ServiceTitle>
                                    {service.description && (
                                        <Typography variant="body2" color="text.secondary" sx={{ mt: 1 }}>
                                            {service.description}
                                        </Typography>
                                    )}
                                    {service.price && (
                                        <Typography variant="body1" color="primary" sx={{ mt: 1, fontWeight: 'bold' }}>
                                            {service.price} ريال
                                        </Typography>
                                    )}
                                    {service.duration_minutes && (
                                        <Typography variant="body2" color="text.secondary" sx={{ mt: 0.5 }}>
                                            المدة: {service.duration_minutes} دقيقة
                                        </Typography>
                                    )}
                                </Box>
                            </ServiceCard>
                        ))}
                    </ServicesGrid>
                </CategorySection>
            </Container>

            <PractitionerModal
                open={modalOpen}
                onClose={handleCloseModal}
                practitioners={practitioners}
                serviceName={selectedService?.name || 'جميع المتخصصين'}
                loading={practitionersLoading}
            />
        </Box>
    );
};

export default ServicesShowcase;
