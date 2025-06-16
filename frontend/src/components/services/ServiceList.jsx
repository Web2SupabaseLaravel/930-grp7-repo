import React, { useState, useEffect } from 'react';
import { 
    Table, TableBody, TableCell, TableContainer, TableHead, 
    TableRow, Paper, Button, IconButton 
} from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import { getServices, deleteService } from '../../services/api';

const ServiceList = ({ onEdit, refreshTrigger }) => {
    const [services, setServices] = useState([]);

    useEffect(() => {
        loadServices();
    }, [refreshTrigger]);

    const loadServices = async () => {
        try {
            const response = await getServices();
            console.log('Services response:', response); // للتحقق من البيانات
            setServices(response.data || []); // التأكد من وجود مصفوفة حتى لو كانت فارغة
        } catch (error) {
            console.error('Error loading services:', error);
            setServices([]); // تعيين مصفوفة فارغة في حالة الخطأ
        }
    };

    const handleDelete = async (id) => {
        try {
            await deleteService(id);
            loadServices();
        } catch (error) {
            console.error('Error deleting service:', error);
        }
    };

    return (
        <TableContainer component={Paper}>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableCell>Name</TableCell>
                        <TableCell>Description</TableCell>
                        <TableCell>Duration (minutes)</TableCell>
                        <TableCell>Price</TableCell>
                        <TableCell>Actions</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {services.map((service) => (
                        <TableRow key={service.id}>
                            <TableCell>{service.name}</TableCell>
                            <TableCell>{service.description}</TableCell>
                            <TableCell>{service.duration_minutes}</TableCell>
                            <TableCell>{service.price}</TableCell>
                            <TableCell>
                                <IconButton onClick={() => onEdit(service)}>
                                    <EditIcon />
                                </IconButton>
                                <IconButton onClick={() => handleDelete(service.id)}>
                                    <DeleteIcon />
                                </IconButton>
                            </TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer>
    );
};

export default ServiceList;