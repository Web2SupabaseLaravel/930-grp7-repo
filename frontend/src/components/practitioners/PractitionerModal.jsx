import React, { useState } from 'react';
import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    Button,
    Typography,
    Box,
    Card,
    CardContent,
    Grid,
    Chip,
    IconButton
} from '@mui/material';
import { Close as CloseIcon, Person as PersonIcon } from '@mui/icons-material';
import PractitionerChat from './PractitionerChat';

const PractitionerModal = ({ open, onClose, practitioners, serviceName, loading }) => {
    const [selectedPractitioner, setSelectedPractitioner] = useState(null);
    const [chatOpen, setChatOpen] = useState(false);

    const handlePractitionerClick = (practitioner) => {
        setSelectedPractitioner(practitioner);
        setChatOpen(true);
    };

    const handleChatClose = () => {
        setChatOpen(false);
        setSelectedPractitioner(null);
    };

    return (
        <Dialog
            open={open}
            onClose={onClose}
            maxWidth="md"
            fullWidth
            sx={{ direction: 'rtl' }}
        >
            <DialogTitle sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <Typography variant="h6">
                    المتخصصين في خدمة: {serviceName}
                </Typography>
                <IconButton onClick={onClose} size="small">
                    <CloseIcon />
                </IconButton>
            </DialogTitle>
            
            <DialogContent>
                {loading ? (
                    <Box sx={{ textAlign: 'center', py: 4 }}>
                        <Typography>جاري تحميل المتخصصين...</Typography>
                    </Box>
                ) : practitioners.length === 0 ? (
                    <Box sx={{ textAlign: 'center', py: 4 }}>
                        <PersonIcon sx={{ fontSize: 64, color: 'text.secondary', mb: 2 }} />
                        <Typography variant="h6" color="text.secondary">
                            لا يوجد متخصصين متاحين لهذه الخدمة حالياً
                        </Typography>
                    </Box>
                ) : (
                    <Grid container spacing={2}>
                        {practitioners.map((practitioner) => (
                            <Grid item xs={12} sm={6} key={practitioner.id}>
                                <Card sx={{ height: '100%', cursor: 'pointer' }} onClick={() => handlePractitionerClick(practitioner)}>
                                    <CardContent>
                                        <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
                                            <PersonIcon sx={{ mr: 1, color: 'primary.main' }} />
                                            <Typography variant="h6">
                                                متخصص #{practitioner.id}
                                            </Typography>
                                        </Box>
                                        
                                        {practitioner.specialization && (
                                            <Box sx={{ mb: 2 }}>
                                                <Typography variant="subtitle2" color="text.secondary" gutterBottom>
                                                    التخصص:
                                                </Typography>
                                                <Chip 
                                                    label={practitioner.specialization} 
                                                    color="primary" 
                                                    variant="outlined"
                                                    size="small"
                                                />
                                            </Box>
                                        )}
                                        
                                        {practitioner.qualifications && (
                                            <Box sx={{ mb: 2 }}>
                                                <Typography variant="subtitle2" color="text.secondary" gutterBottom>
                                                    المؤهلات:
                                                </Typography>
                                                <Typography variant="body2">
                                                    {practitioner.qualifications}
                                                </Typography>
                                            </Box>
                                        )}
                                        
                                        {practitioner.working_hours && (
                                            <Box sx={{ mb: 2 }}>
                                                <Typography variant="subtitle2" color="text.secondary" gutterBottom>
                                                    ساعات العمل:
                                                </Typography>
                                                <Typography variant="body2">
                                                    {practitioner.working_hours}
                                                </Typography>
                                            </Box>
                                        )}
                                        
                                        {practitioner.contact && (
                                            <Box>
                                                <Typography variant="subtitle2" color="text.secondary" gutterBottom>
                                                    معلومات التواصل:
                                                </Typography>
                                                <Typography variant="body2">
                                                    {practitioner.contact}
                                                </Typography>
                                            </Box>
                                        )}
                                    </CardContent>
                                </Card>
                            </Grid>
                        ))}
                    </Grid>
                )}
            </DialogContent>
            
            <DialogActions>
                <Button onClick={onClose} variant="contained">
                    إغلاق
                </Button>
            </DialogActions>
             <PractitionerChat
                open={chatOpen}
                onClose={handleChatClose}
                practitioner={selectedPractitioner}
            />
        </Dialog>
    );
};

export default PractitionerModal;