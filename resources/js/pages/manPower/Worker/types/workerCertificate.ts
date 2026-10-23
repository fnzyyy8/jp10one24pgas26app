export type WorkerCertificateDocumentType = 'PDF' | 'JPG' | 'PNG' | 'WEBP';

export interface WorkerCertificate {
    id: number;
    certificate_name: string;
    expired_date: string | null;
    document_type: WorkerCertificateDocumentType | null;
    document_url: string | null;
}
