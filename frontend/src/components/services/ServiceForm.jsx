import React, { useState, useEffect } from 'react';
import { 
    Dialog, DialogTitle, DialogContent, DialogActions,
    TextField, Button 
} from '@mui/material';
import { createService, updateService } from '../../services/api';

const ServiceForm = ({ open, onClose, service = null }) => {
    const [formData, setFormData] = useState({
        name: '',
        description: '',
        duration_minutes: '',
        price: ''
    });

    useEffect(() => {
        if (service) {
            setFormData(service);
        }
    }, [service]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            if (service) {
                await updateService(service.id, formData);
            } else {
                await createService(formData);
            }
            onClose(true);
        } catch (error) {
            console.error('Error saving service:', error);
        }
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    return (
        <Dialog open={open} onClose={() => onClose(false)}>
            <DialogTitle>{service ? 'Edit Service' : 'New Service'}</DialogTitle>
            <form onSubmit={handleSubmit}>
                <DialogContent>
                    <TextField
                        fullWidth
                        margin="normal"
                        label="Name"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        required
                    />
                    <TextField
                        fullWidth
                        margin="normal"
                        label="Description"
                        name="description"
                        value={formData.description}
                        onChange={handleChange}
                        required
                    />
                    <TextField
                        fullWidth
                        margin="normal"
                        label="Duration (minutes)"
                        name="duration_minutes"
                        type="number"
                        value={formData.duration_minutes}
                        onChange={handleChange}
                        required
                    />
                    <TextField
                        fullWidth
                        margin="normal"
                        label="Price"
                        name="price"
                        type="number"
                        value={formData.price}
                        onChange={handleChange}
                        required
                    />
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => onClose(false)}>Cancel</Button>
                    <Button type="submit" variant="contained" color="primary">
                        {service ? 'Update' : 'Create'}
                    </Button>
                </DialogActions>
            </form>
        </Dialog>
    );
};

export default ServiceForm;